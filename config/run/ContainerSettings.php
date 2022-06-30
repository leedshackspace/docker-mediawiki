<?php

# This config file includes all staticly defined config based upon the pre-configured container settings
# Only change if changing the container settings

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

#############
# Path Stuff
#############

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
# Produces intended behaviour as described in EMF's original readme
$containerUrlPrefix = getenv("URL_PREFIX") ? '/'.getenv("URL_PREFIX") : '';
$wgScriptPath = "$containerUrlPrefix/w";
$wgArticlePath = "$containerUrlPrefix/wiki/$1";
$wgUsePathInfo = true;

#################
# Tool settings
#################

# ImageMagick 

$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

####################
# Extensions/Skins
####################

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

# Enabled skins.
# The following skins were automatically enabled:
wfLoadSkin( 'MonoBook' );
wfLoadSkin( 'Timeless' );
wfLoadSkin( 'Vector' );


# Enabled extensions. Most of the extensions are enabled by adding
# wfLoadExtension( 'ExtensionName' );
# to LocalSettings.php. Check specific extension documentation for more details.
# The following extensions were automatically enabled:

# All the default bundled extensions
wfLoadExtension( 'CategoryTree' );
wfLoadExtension( 'Cite' );
wfLoadExtension( 'CiteThisPage' );
wfLoadExtension( 'CodeEditor' ); # Requires 'WikiEditor
#wfLoadExtension( 'ConfirmEdit' );
#wfLoadExtension( 'Gadgets' );
#wfLoadExtension( 'ImageMap' );
#wfLoadExtension( 'InputBox' );
wfLoadExtension( 'Interwiki' );
#wfLoadExtension( 'LocalisationUpdate' );
#wfLoadExtension( 'MultimediaViewer' );
wfLoadExtension( 'Nuke' );
#wfLoadExtension( 'OATHAuth' );
#wfLoadExtension( 'PageImages' );
wfLoadExtension( 'ParserFunctions' );
#wfLoadExtension( 'PdfHandler' );
#wfLoadExtension( 'Poem' );
wfLoadExtension( 'Renameuser' );
wfLoadExtension( 'ReplaceText' );
#wfLoadExtension( 'Scribunto' );
#wfLoadExtension( 'SecureLinkFixer' );
#wfLoadExtension( 'SpamBlacklist' );
#wfLoadExtension( 'SyntaxHighlight_GeSHi' );
#wfLoadExtension( 'TemplateData' );
#wfLoadExtension( 'TextExtracts' );
#wfLoadExtension( 'TitleBlacklist' );
wfLoadExtension( 'VisualEditor' );
wfLoadExtension( 'WikiEditor' );

# Externally provided by composer
wfLoadExtension( 'PageForms' );
wfLoadExtension( 'Maps' );
wfLoadExtension( 'SemanticMediaWiki' );
# wfLoadExtension( 'SubPageList' ); Broken extension do not use