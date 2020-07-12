<?php
// ########################################################################################
// -------------- Summary
// This class can be used to convert a MsWord document to html, rtf or text. As MsWord can read txt and rtf, input
// can be doc, but also be txt or rtf
// Of course, you need MsWord installed on the server, so Windows OS.

// -------------- Author
// Logan Dugenoux - 2003
// logan.dugenoux@netcourrier.com
// http://www.peous.com/logan/

// -------------- License
// GPL

// -------------- Methods :
// - convertWordDocumentToString($inFile , $outFormat="html")				"html", "htm", "rtf" or "txt"
// - convertWordDocumentToFile($inFile ,$outFile, $outFormat="html")		"html", "htm", "rtf" or "txt"
// - cleanWordHTML( ... ) see help below
// - getLastError() returns last error if function returns false.

// ------------- Example :
// require ("wordDocumentHandler.php");
// $w = new wordDocumentHandler();
// $myWordFile = "my doc file.doc";
// $txt = $w->convertWordDocumentToString( $myWordFile , "txt" );
// echo  $txt;

// ------------- About COM
// http://php.planetmirror.com/manual/en/faq.com.php

// * If you got error "Cannot instantiate non-existent class: com"
// Edit your php.ini and set com.allow_dcom=true

// Have fun !!!
// ########################################################################################
class wordDocumentHandler {
    var $lastError = "";

    function wordDocumentHandler() {
    }

    function getLastError() {
        return $this->lastError;
    }

    function convertWordDocumentToString( $inFile , $outFormat = "html" ) {
        // working space
        $dataPath = dirname( __FILE__ ) . "/wordDocumentHandler/";
        @mkdir( $dataPath );
        $tempFile = tempnam ( $dataPath, "wrd" );
        $dataPath = str_replace( ".", "", $tempFile ) . "/";
        @mkdir( $dataPath );
        $htmlFile = $dataPath . "document.html";
        unlink( $tempFile ); // it is created I only want a name !
        // Conversion
        $this->convertWordDocumentToFile( $inFile, $htmlFile, $outFormat );
        $htmlCnt = file_get_contents( $htmlFile );
        // Remove temp files
        $this->recursiveDirDelete( $dataPath );

        return $htmlCnt;
    }

    function convertWordDocumentToFile( $inFile , $outFile, $outFormat = "html" ) {
        $this->lastError = "";
        $outFormatNumber = 8; // default = HTML
        if ( $outFormat == "txt" ) $outFormatNumber = 2;
        if ( $outFormat == "rtf" ) $outFormatNumber = 6;
        // Create MsWord instance
        $comObject = new COM( "Word.Application" );
        if ( !$comObject ) {
            $this->lastError = "COM object of microsoft word cannot be found. Check COM permissions or Office install";
            return false;
        }
        // Open doc in Word
        if ( !$comObject->Documents->Open( $inFile ) ) {
            $comObject->Quit( 0 ); // Always quit ! otherwise msword.exe will stay
            $this->lastError = $inFile . " cannot be opened by Word";
            return false;
        }
        // Save doc
        if ( !$comObject->ActiveDocument->SaveAs( $outFile, $outFormatNumber ) ) {
            $comObject->Quit( 0 ); // Always quit ! otherwise msword.exe will stay
            $this->lastError = "MsWord cannot save " . $outFile;
            return false;
        }

        $comObject->Quit( 0 ); // Always quit ! otherwise msword.exe will stay
        return true;
    }

    function cleanWordHTML( &$htmlCnt, // tring to clean
        // chaine a nettoyer
        $supprimer_tout_style = 1, // remove all styles, so removes CSS also
        // supprimer tous les styles. supprime la mise en forme CSS donc...
        $supprimer_if = 1, // remove all M$ if
        // supprimer tout ce qui entre "if" microsoft
        $supprimer_espaces = 1, // remove dbl spaces (necesary for the 3 next options)
        // supprimer les dbl espaces (nécessaires pour les 3 options suivantes)
        $supprimer_def_styles_inutiles = 1, // remove unused CSS (>200 Ko !!)
        // virer les def de style CSS non utilisées dans class=...
        $recherche_balises_approfindie = 0, // search styles within tags	(SLOOOOW)
        // recherche précise de toutes les balises <h1>, <h2>, ...
        $binder_nom_classes = 1, // shorten class names binding them
        // remplacer les noms des classes par d'autres plus courts
        $supprimer_les_style_none = 1, // remove "border=none"
        // supprie tous les styles "border:none", etc... qui sont pris comme tels par défaut
        $supprimer_trucs_word = 1, // remove various useless tags
        // supprime diverses balises WORD
        $supprimer_balises_span = 1, // remove <span> tags (not thein content)
        // supprime les balises <span> (pas leur contenu)
        $supprimer_toutes_balises = 0 // remove all tags (better use TXT output for conversion)
        ) {
        // ---------------
        // Do this before processing classes
        if ( $supprimer_espaces ) {
            $htmlCnt = str_replace( "\n", " ", $htmlCnt );
            $htmlCnt = str_replace( "\r", " ", $htmlCnt );
            $htmlCnt = str_replace( "\t", " ", $htmlCnt );
            $this->virerEspace( $htmlCnt );
        }
        // Remove IFs
        if ( $supprimer_if ) {
            $this->extractIf( $htmlCnt, 0 );
        }

        if ( $supprimer_toutes_balises ) {
            $htmlCnt = ereg_replace( "<style>[^<]*</style>", "", $htmlCnt ); // ici on vire aussi le contenu
            $htmlCnt = ereg_replace( "<[^>]*>", "", $htmlCnt );
        }

        if ( $supprimer_def_styles_inutiles ) {
            // ---- Find used tags
            $lesClasses = array();
            // -1 within the styles class=...
            $balises = array();
            preg_match_all( "(class=[^>]*)", $htmlCnt, $balises, PREG_SET_ORDER );

            for ( $i = 0;$i <= sizeof( $balises );$i++ ) {
                $good = explode( " ", $balises[$i][0] );
                if ( strlen( substr( $good[0], 6 ) ) > 0 )
                    $lesClasses[substr( $good[0], 6 )] = 1;
            }

            if ( $recherche_balises_approfindie ) {
                // SLOOOOOOOOOOOOOW
                // -2 Directly tag names	<tagName>
                $balises = array();
                preg_match_all( "(<[^>]*)", $htmlCnt, $balises, PREG_SET_ORDER );
                for ( $i = 0;$i <= sizeof( $balises );$i++ ) {
                    $good = explode( " ", $balises[$i][0] );
                    if ( substr( $good[0], 1, 1 ) == "/" )
                        continue;
                    if ( substr( $good[0], 1, 1 ) == "!" )
                        continue;
                    if ( strlen( substr( $good[0], 1 ) ) > 0 )
                        $lesClasses[substr( $good[0], 1 )] = 1;
                }
            } else {
                $lesClasses["h1"] = 2;
                $lesClasses["h2"] = 2;
                $lesClasses["h3"] = 2;
                $lesClasses["h4"] = 2;
                $lesClasses["h5"] = 2;
                $lesClasses["h6"] = 2;
            }
            // end of research
            $balisesOk = "";
            foreach( $lesClasses as $k => $type ) {
                if ( $balisesOk )
                    $balisesOk .= "|";
                $balisesOk .= $k;
            }
            $regExpression = "((" . $balisesOk . ") *\\{[^\\}]*\\})";
            // Find used styles
            $stylesDef = array();
            preg_match_all( $regExpression, $htmlCnt, $stylesDef , PREG_SET_ORDER );
            $stylesDefString = "";
            for ( $i = 0;$i <= sizeof( $stylesDef );$i++ ) {
                $stylesDefString .= "\n" . $stylesDef[$i][0] . "\n";
            }

            if ( $binder_nom_classes ) {
                $i = 0;
                foreach( $lesClasses as $k => $type ) {
                    if ( $type == 1 ) { // style
                            $htmlCnt = str_replace( $k, "c" . $i, $htmlCnt );
                        $stylesDefString = str_replace( $k, "c" . $i, $stylesDefString );
                        $i++;
                    }
                }
            }
            // Remove all <style>	... </style> tags
            $pLastStylePos = 0;
            $pStyleBegin = $this->strpoz( $htmlCnt, "<style>", $pLastStylePos );
            $pFirstStyleBegin = $pStyleBegin;
            if ( $pStyleBegin != -1 )
                $pStyleEnd = $this->strpoz( $htmlCnt, "</style>", $pStyleBegin );
            while ( $pStyleBegin != -1 ) {
                $pLastStylePos = $pStyleEnd;
                $htmlCnt = substr( $htmlCnt, 0, $pStyleBegin ) . substr( $htmlCnt, $pStyleEnd + 8 );
                $pStyleBegin = $this->strpoz( $htmlCnt, "<style>", $pLastStylePos );
                if ( $pStyleBegin != -1 )
                    $pStyleEnd = $this->strpoz( $htmlCnt, "</style>", $pStyleBegin );
            }
            // Write only necesary style
            if ( $stylesDefString ) {
                $htmlCnt = substr( $htmlCnt, 0, $pFirstStyleBegin ) . "<style>\n<!--" . $stylesDefString . "-->\n</style>" .
                substr( $htmlCnt, $pFirstStyleBegin );
            }
        }

        if ( $supprimer_tout_style ) {
            $htmlCnt = ereg_replace( "style='[^']*'", "", $htmlCnt );
        }

        if ( $supprimer_les_style_none ) {
            // C bon c par défault !
            $htmlCnt = str_replace( "text-decoration:none", "", $htmlCnt );
            $htmlCnt = str_replace( "text-underline:none", "", $htmlCnt );
            $htmlCnt = str_replace( "border-left:none", "", $htmlCnt );
            $htmlCnt = str_replace( "border-top:none", "", $htmlCnt );
            $htmlCnt = str_replace( "border-bottom:none", "", $htmlCnt );
            $htmlCnt = str_replace( "border-right:none", "", $htmlCnt );
        }

        if ( $supprimer_trucs_word ) {
            $htmlCnt = ereg_replace( "v:shapes=\"[^\"]*\"", "", $htmlCnt );
            $htmlCnt = ereg_replace( "style='tab-stops:[^']*'", "", $htmlCnt );
            $htmlCnt = ereg_replace( "<o[^>]*></o:p>", "", $htmlCnt ); // balises span vides
            $htmlCnt = ereg_replace( "<p[^>]*></p>", "", $htmlCnt ); // balises span vides
            $htmlCnt = ereg_replace( "mso-(^[';])*", "", $htmlCnt );
            $htmlCnt = ereg_replace( "field-code-(^[';])*", "", $htmlCnt );
        }

        if ( $supprimer_balises_span ) {
            $htmlCnt = ereg_replace( "<span[^>]*>", "", $htmlCnt );
            $htmlCnt = str_replace( "</span>", "", $htmlCnt );
        }
        // Last optim
        if ( $supprimer_espaces ) {
            $this->virerEspace( $htmlCnt );
        }
    }
    // --------------- PRIVATE FUNCTIONS -----------------
    function virerEspace( &$htmlCnt ) {
        // much much faster than $htmlCnt = ereg_replace( " +", " ", $htmlCnt );
        // and works if there is less than 256 spaces at the same time
        $htmlCnt = str_replace( "                                ", " ", $htmlCnt );
        $htmlCnt = str_replace( "                ", " ", $htmlCnt );
        $htmlCnt = str_replace( "        ", " ", $htmlCnt );
        $htmlCnt = str_replace( "    ", " ", $htmlCnt );
        $htmlCnt = str_replace( "  ", " ", $htmlCnt );
    }

    function extractIf( &$str, $pos ) {
        $pIf1 = $this->strpoz( $str, "<![if", $pos );
        $pIf2 = $this->strpoz( $str, "<!--[if", $pos );
        $pIf = $this->zmin( $pIf1 , $pIf2 );
        if ( $pIf >= 0 ) {
            $pIfEnd = $this->strpoz( $str, ">", $pIf );
            $pNextIf1 = $this->strpoz( $str, "<![if", $pIfEnd );
            $pNextIf2 = $this->strpoz( $str, "<!--[if", $pIfEnd );
            $pNextIf = $this->zmin( $pNextIf1, $pNextIf2 );
            if ( $pNextIf >= 0 ) {
                $this->extractIf( $str, $pNextIf );
            }
            $pNextEndIf1 = $this->strpoz( $str, "<![endif]", $pIfEnd );
            $pNextEndIf2 = $this->strpoz( $str, "<![endif]", $pIfEnd );
            $pNextEndIf = $this->zmin( $pNextEndIf1, $pNextEndIf2 );

            $pNextEndIfEnd1 = $this->strpoz( $str, ">", $pNextEndIf );
            $pNextEndIfEnd2 = $this->strpoz( $str, ">", $pNextEndIf );
            $pNextEndIfEnd = $this->zmin( $pNextEndIfEnd1, $pNextEndIfEnd2 );

            $pCond = $this->strpoz( $str, "[", $pIf );
            $ifCondition = substr( $str, $pCond + 1 + 2 + 1, $pIfEnd - $pCond-2-2-1 );

            $oki = false;
            if ( $ifCondition == "!vml" ) {
                $oki = true;
            }
            $insideIf = "";
            // $pos		$pIf	$pIfEnd				$pNextEndIf	$pNextEndIfEnd
            // ....	<![if...	>		...		<![end if]>						....
            if ( $oki ) {
                $insideIf = substr( $str, $pIfEnd + 1, $pNextEndIf - ( $pIfEnd + 1 ) );
            }

            $str = substr( $str, 0, $pIf ) . $insideIf .
            substr( $str, $pNextEndIfEnd + 1 );
        } else {
            return substr( $str, $pos );
        }
    }

    function zmin( $p1, $p2 ) {
        return ( ( $p1 >= 0 ) && ( ( $p1 < $p2 ) || ( $p2 == -1 ) ) )?$p1:$p2;
    }
    function strpoz( $mystring, $findme, $start ) {
        $res = @strpos( $mystring, $findme, $start );
        if ( $res === false )
            return -1;
        return $res;
    }

    function recursiveDirDelete( $thePath ) {
        if ( false === @is_dir( $thePath ) ) {
            @unlink( $thePath );
            clearstatcache();
            if ( @file_exists( $thePath ) ) {
                if ( substr_count( $thePath, ":" ) ) {
                    @system( "del " . eregi_replace( "/", "\\", $thePath ) );
                } else {
                    @system( "rm $thePath" );
                }
            }
            clearstatcache();
            if ( @file_exists( $thePath ) ) {
                return false;
            } else {
                return true;
            }
        } else {
            $dh = @opendir( $thePath );
            while ( ( $file = @readdir( $dh ) ) !== false ) {
                if ( $file != "." && $file != ".." ) {
                    $fullpath = $thePath . $file;
                    if ( @is_dir( $fullpath ) )$fullpath .= "/";
                    if ( !$this->recursiveDirDelete( $fullpath ) ) {
                        closedir( $dh );
                        return false;
                    }
                }
            }
            @closedir( $dh );
            @rmdir( $thePath );
            clearstatcache();
            if ( @file_exists( $thePath ) ) {
                if ( substr_count( $thePath, ":" ) ) {
                    @system( "del " . eregi_replace( "/", "\\", $thePath ) );
                } else {
                    @system( "rmdir $thePath" );
                }
            }
            clearstatcache();
            if ( @file_exists( $thePath ) ) {
                return false;
            } else {
                return true;
            }
        }
    }
}

?>