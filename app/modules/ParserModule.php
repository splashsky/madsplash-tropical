<?php
	define('SECURITY_CODE', __LINE__);
	
	error_reporting(E_ALL ^ E_NOTICE);
	
	function getParserPath() {
		
		// An absolute path in a constant, to allow us
		// to link smilies directly, without
		// changing paths through different applications.
	
		$f = __FILE__;
		$f = str_replace('\\', '/', $f); // Windows
		
		$dr = preg_quote($_SERVER['DOCUMENT_ROOT']);
		
		
		
		$parser_filename = basename($f);
		
		$path = preg_replace("#^($dr)#", null, $f);
		$path = pathinfo($path, PATHINFO_DIRNAME) . '/' . $parser_filename;
		
		
		
		define('PARSER_FILENAME', $parser_filename);
		return define('PARSER_ORIGINAL_PATH', $path);
		
	}
	
	getParserPath();
	
	
	
	
	
	
	
	class ParserModule {
	
		protected $codeline = SECURITY_CODE;
		
		
		// Tag repo, to declare what tags can be used.
		private $bbtags = array(
			
			1 => '[u]',
			
			2 => '[/u]',
			
			3 => '[i]',
			
			4 => '[/i]',
			
			5 => '[b]',
			
			6 => '[/b]',
			
			7 => '[cool]',
			
			8 => '[/cool]',
			
			9 => '[code]',
			
			10 => '[/code]',
			
			11 => '[indent]',
			
			12 => '[/indent]',
			
			13 => '[lyrics]',
			
			14 => '[/lyrics]',
			
			15 => '[smallcaps]',
			
			16 => '[/smallcaps]',
			
			17 => '[big]',
			
			18 => '[/big]',
			
			19 => '[small]',
			
			20 => '[/small]',
			
			21 => '[tt]',
			
			22 => '[/tt]',
			
			23 => '[sub]',
			
			24 => '[/sub]',
			
			25 => '[sup]',
			
			26 => '[/sup]'
			
		);
		
		
		
		// Replacement repo, for what to change the BBCode tags into.
		private $reptags = array(
		
			1 => '<span style="text-decoration: underline;">',
		
			2 => '</span>',
		
			3 => '<em>',
			
			4 => '</em>',
	
			5 => '<strong>',
	
			6 => '</strong>',
	
			7 => '<span style="font-family: Verdana, Arial, Helvetica, sans-serif; letter-spacing: 2px; word-spacing: 3px; font-size: 13px; font-weight: bold; font-style: italic; color: #333399; font-variant: small-caps; height: 12px; padding-left: 9pt; padding-right: 6pt; vertical-align: middle; display: block;">',
		
			8 => '</span>',
		
			9 => '<div style="width: 80%; max-height: 320px; overflow: auto; text-align: left; background-color: rgba(150, 150, 150, 0.1); display: block; padding-left: 20px;"><code style="white-space: pre;">',
		
			10 => "\n</code></div>",
	
			11 => '<blockquote>',
	
			12 => '</blockquote>',
	
			13 => '<span style="margin-left: 30px; font-style: italic; display: block;">',
	
			14 => '</span>',
	
			15 => '<span style="font-variant: small-caps;">',
	
			16 => '</span>',
	
			17 => '<span style="font-size: 22px;">',
	
			18 => '</span>',
	
			19 => '<span style="font-size: 10px;">',
	
			20 => '</span>',
	
			21 => '<tt>',
	
			22 => '</tt>',
	
			23 => '<sub>',
	
			24 => '</sub>',
	
			25 => '<sup>',
	
			26 => '</sup>'
	
		);
		
		
		
		// XHTML-like tag repo.
		private $xhtml = array (
			'[bull /]' => '<big>&bull;</big>',
			
			'[copyright /]' => '&copy;',
			
			'[registered /]' => '&reg;',
			
			'[tm /]' => '<big>&trade;</big>'
		);
		
		
		
		// Repos for smilies! Full name and simplified tags.
		private $emoticons = array('confident', 'happy', 'crying', 'friendly', 'evil', 'panic', 'indifferent', 'angel', 'teasing', 'angry', 'polite', 'mad', 'tearing', 'yelling', 'sad', 'skeptical');
		
		private $altEmoticons = array(':)', ':D', ';(', ';)', '&gt;:)', ':O', ':|', 'O:)', ':P', ':(', ':3', ':X', ':@', ':()', ':/', ':\\');
		
		
		
		protected $parserVerion = "v1.0.0";
		
		protected $resourceBin = "http://madsplash.net/Resources";
		
		
		
		
		function __construct() {
			## TODO no need for special construct rules yet.
		}
		
		
		
		public function SpamShield($email) {
		
			## This changes every character in an email address to it's ordinal value.
			## Makes it that much harder for spambots to get the email address.
			## The visitor won't see a difference.
			
			$email = trim($email);
			
			$intEmail = "";
			
			$num = 0;
			
			
			
			while($num < strlen($email)) {
				
				if(empty($intemail)) {
				
					$intemail = "&#" . ord($email[$num]);
					
				} else {
				
					$intemail .= "&#" . ord($email[$num]);
					
				}
				
				
				$num++;
				
			}
			
			
			
			return $intemail;
			
		}
		
		
		
		public function alterArray($array, $operation = "") {
			
			switch($operation) {
				
				case "lower":
					foreach($array as $op1Num => $op1Data) {
						
						$array[$op1Num] = strtolower($op1Data);
						
					}
					
					break;
					
				case "clean":
					foreach($array as $op2Num => $op2Data) {
						
						if($op2Data == null || strlean($op2Data) < 1 || empty($op2Data)) {
							
							unset($array[$op2Num]);
							
						}
						
					}
					
					break;
					
				default:
					return $array;
				
			}
			
			
			
			return $array;
			
		}
		
		
		
		// Enhanced str_ireplace
		function replaceTool($seek, $replace, $subject) {
			
			if(function_exists("str_ireplace")) {
				
				return str_ireplace($seek, $replace, $subject);
				
			} else {
				
				$seek = preg_quote($seek, "#");
				
				return preg_replace("#" . $seek . "#i", $replace, $subject);
				
			}
			
		}
		
		
		
		public function parse($string, $toBr = false, $justParse = false, $protectMails = true, $onShutdown = "") {
			
			// A R G U M E N T S
			
				# $string = the text you want to format
				
				# $toBr = convert newlines (\n) to <br /> (OPTIONAL) disabled by default
				
				# $justParse = disable it when you intend to print text directly on the page. (OPTIONAL) disabled by default
					# In the current mode, it will save your parsed text in some variable.
					
				# $protectMails = protect emails via the SpamShield() function. (OPTIONAL) enabled by default
				
				# $onShutdown = PHP goes here. The PHP will fire once the Parser is done parsing.
				
				
				
			// T H E   C O R E
			
			$s = (string) $string;
			
			if(empty($s)) {
				
				echo "It would seem that the data you want parsed cannot be found.";
				
				echo "<br /><br />";
				
				echo "The Parser will now exit.";
				
				return;
				
			}
			
			if(PHP_VERSION <= 4) {
				
				self::__construct();
				
			}
			
			
			
			## htmlentities() will rid the string of garbage. It basically cleans up.
			## Kudos to Atli from Dream.in.Code for showing me this function!
			$s = htmlentities($s, ENT_QUOTES, 'UTF-8');
			
			
			
			// B A S I C   P A R S E   (M A I N)
			for($b = 1; $b < count($this->bbtags); $b++) {
				
				$bbtagsNeedle = '#' . preg_quote($this->bbtags[$b], '#') . "(.*)" . preg_quote($this->bbtags[$b + 1], '#') . '#Uis'; // The needle
				
				$bbtagsReplacement = $this->reptags[$b] . "$1" . $this->reptags[++$b];
				
				$s = preg_replace($bbtagsNeedle, $bbtagsReplacement, $s);
				
			}
		
		
		
			foreach($this->xhtml as $xhtmlBBTags => $xhtmlReplacement) {
				
				$s = $this->replaceTool($xhtmlBBTags, $xhtmlReplacement, $s);
				
			}
		
		
		
			## Fix invalid link formats.
			$s = preg_replace("#\[url\](www\..+)\[\/url\]#i", "[url=http://$1]$1[/url]", $s);
			
			$s = preg_replace("#\[url\=(www\..+)\](.*)\[\/url\]#i", "[url=http://$1]$2[/url]", $s);
		
		
		
			## It can't be [php].+
			## It must be [php]\n.+
			$s = preg_replace("#\[php\]([^\r\n])#i", "[php]\r\n$1", $s);
			
			## Same, but for [/php]
			$s = preg_replace("#([^\r\n])\[\/php\]#i", "$1\r\n[/php]", $s);
			
			
			
			## Remove the prepended <?php || <? || php closing tag.
			$s = preg_replace("#\[php\](\r\n|(\r\n)+|)((\&lt\;\?php)|(\&lt\;\?))#i", "[php]", $s);
			
			$s = preg_replace("#(\?\&gt\;)(\r\n|(\r\n)+|)\[\/php\]#i", "[/php]", $s);
			
			
			
			## Prepend <?php and php closing tag.
			$s = preg_replace("#\[php\]#i", "[php]\n<?php", $s);
			
			$s = preg_replace("#\[\/php\]#i", "?>\n[/php]", $s);
			
			
			
			// P A R S E
			$s = preg_replace("#\[url\=(.*)\](.*)\[\/url\]#Ui", "<a href=\"$1\" target=\"_blank\">$2</a>", $s);
			
			$s = preg_replace("#\[url\](.*)\[\/url\]#Ui", "<a href=\"$1\" target=\"_blank\">$1</a>", $s);
		
			$s = preg_replace("#\[img\](.*)\[\/img\]#Ui", "<img src=\"$1\" border=\"0\" />", $s);
		
			$s = preg_replace("#\[email\=(.*)\](.*)\[\/email\]#Ui", "<a href=\"mailto: $1\">$2</a>", $s);
		
			$s = preg_replace("#\[email\](.*)\[\/email\]#Ui", "<a href=\"mailto: $1\">$1</a>", $s);
		
			$s = preg_replace("#\[font\=(.*)\](.*)\[\/font\]#Ui", "<span style=\"font-family: $1;\">$2</span>", $s);
		
			$s = preg_replace("#\[color\=(\#[0-9A-F]{0,6}|[A-z]+)\](.*)\[\/color\]#Ui", "<span style=\"color: $1;\">$2</span>", $s);
			
			
			
			## [php]...[/php] parse.
			$s = preg_replace("#\[php\][\n\r|\n](.*)[\n\r|\n]\[\/php\]#Uise", "'<div style=\"width: 80%; overflow: auto; text-align: left; display: block; padding-left: 20px;\">'.highlight_string(html_entity_decode('\\1', ENT_QUOTES), 1).'</div>'", $s);
		
			## <span> for PHP5, <font> for PHP4.
			$s = preg_replace("#\<\/(span|font)\>\[\/php\]#i", "</$1>\n</$1>\n</code><div style=\"display: block;\">", $s);
			
			
			
			## [youtube] code.
			$s = preg_replace("#\[youtube\](.*)\[\/youtube\]#Ui", "<object width=\"425\" height=\"350\"><embed src=\"http://www.youtube.com/v/$1\" type=\"application/x-shockwave-flash\" width=\"425\" height=\"350\"></embed></object>", $s);
		
		
		
			if(PHP_VERSION >= 5) {
				
				$highlight_string_type = "span";
				
			} else {
				
				$highlight_string_type = "font";
				
			}
		
		
		
			$s = preg_replace("#\[php\]\<#i", "</div><code><$highlight_string_type style=\"color: #000000;\">\n<", $s);
		
		
		
			## [list]...[/list] parse.
			if(preg_match("#\[list\](.*?)\[\/list\]#is", $s)) {
				
				preg_match_all("#\[list\](.*?)\[\/list\]#is", $s, $list);
				
				$list = $list[1];
				
				$backupList = $list;
				
				
				## Now we seperate the lines.
				
				
				foreach($list as $listNum => $lt) {
					
					$lt = explode("\n", $lt);
					
					unset($lt[0], $lt[count($lt)]); ## Getting rid of the first and last arrays.
					
					
					foreach($lt as $ltaNum => $lta) {
						
						$ltw = str_replace("\n", '', $lta);
						
						$lt[$ltaNum] = '<li>' . $lta . '</li>';
						
					}
					
					
					$lt = implode("", $lt);
					
					$list[$listNum] = '<ul style="list-style-type: square;>"' . "\n" . $lt . "\n" . '</ul>';
					
					
					
					## Finally, replace.
					foreach($backupList as $backupListNum => $bla) {
						
						$s = str_replace($bla, $list[$backupListNum], $s);
						
					}
					
				}
				
				$s = $this->replaceTool('[list]<ul', '<ul', $s);
				
				$s = $this->replaceTool('</ul>[/list]', '</ul>', $s);
				
			}
			
			## Clean empty lists.
			$s = preg_replace("#\<li\>([\r\n])\<\/li\>#", '', $s);
			
			
			
			## Fix line formats. Necessary for the deparsing process.
			$s = $this->replaceTool('</li><li>', "</li>\n<li>", $s);
		
		
		
		
		
			// E X T R A S
			if($protectMails) {
				
				$emails = preg_match_all("#\<a href\=\"mailto\: (.*)\"\>#Ui", $s, $emailsFound);
				
				$correctEmails = $emailsFound[1];
				
				
				
				foreach($correctEmails as $emailNum => $emailContent) {
					
					$protected = $this->SpamShield($correctEmails[$emailNum]);
					
					$currentEmail = $correctEmails[$emailNum];
					$currentEmail = str_replace('#', '\#', $currentEmail);
					
					$s = preg_replace("#\<a href=\=\"mailto\: $currentEmail\"\>#i", "<a href=\"mailto $protected\">", $s);
									
				}
			
			
			
				$simplemPattern = "#\<a href\=\"mailto\: (.*)\"\>(.*)\@(.*)\<\/a\>#Ui"; // * simplem = simple Mail
			
				$simplemProtect = preg_match_all($simplemPattern, $s, $simplemFound);
			
				$simplemImportant = $simplemFound[1];
			
				$smCount = count($simplemImportant);
				
			
			
				for($csm = 0; $sm < $smCount; $csm++) {
					
					$this_simplem = $simplemImportant[$csm];
					
					
					$smExp = explode('&', $this_simplem);
					
					## Clean up the array.
					foreach($smExp as $smArNum => $smEntries) {
						
						$remove = array('#', ';');
						
						$smExp[$smArNum] = str_replace($remove, NULL, $smExp[$smArNum]);
						
						
						if(empty($smExp[$smArNum])) {
							
							unset($smExp[$smArNum]);
							
						}
						
					}
					
					
					foreach($smExp as $numsNum => $asciiStuff) {
						
						$smExp[$numsNum] = sprintf('%c', $asciiStuff);
						
					}
					
					
					foreach($smExp as $nonAlphanumericNum => $nonAlphanumeric) {
						
						// Neither quotemeta() nor preg_quote() are sufficient here.
						
						if($smExp[$nonAlphanumericNum] == '#') {
							
							$smExp[$nonAlphanumericNum] = '\W';
							
						} elseif(!preg_match("#[A-Z0-9]#", $smExp[$nonAlphanumericNum])) {
							
							$smExp[$nonAlphanumericNum] = '\\' . $smExp[$nonAlphanumericNum];
							
						}
						
					}
					
					
					
					$smExp = implode("", $smExp);
					
					
					$this_simplem = str_replace('#', '\#', $this_simplem);
					
					$this_simplem = str_replace('&', '\&', $this_simplem);
					
					
					$this_replace = str_replace(array('\#', '\&'), array('#', '&'), $this_simplem);
					
					
					$s = preg_replace("#\<a href\=\"mailto\: $this_simplem\"\>$smExp\<\/a\>#i", "<a href=\"mailto: $this_replace\">$this_replace</a>", $s);
				
				}
				
			}
		
		
		
			if($toBr) {
				
				## The following line cleans up the garbage made by
				## previous search and replace actions.
				$s = str_replace('<br />', NULL, $s);
				
				$s = nl2br($s);
				
				
				
				## Now, we'll remove the <br />'s within the [code] and [/list] tags.
				## It will also remove the breaks around them.
				## This will greatly enhace the parsed text, especially when using Opera.
				$lineBreaks = array(
					0 => array('<code style="white-space: pre;">', '</code>'),
					1 => array('<ul style="list-style-type: square;">', '</ul>')
				);
				
				foreach($lineBreaks as $breakArray) {
					
					$break1 = $breakArray[0];
					
					$break2 = $breakArray[1];
					
					$break1Quoted = preg_quote($break1, '#');
					
					$break2Quoted = preg_quote($break2, '#');
					
					$breakNeedle = "#" . $break1Quoted . "(.+?)" . $break2Quoted . "#sie";
					
					
					
					$s = preg_replace($breakNeedle, "'" . $break1 . "'.str_replace('<br />', '', str_replace('\\\"', '\"', '$1')).'" . $break2 . "'", $s);
					
					
					
					$s = preg_replace("#\<br \/\>(\r\n)" . $break1Quoted . "#i", "\n" . $break1, $s);
					
					$s = preg_replace("#" . $break2Quoted . "\<br \/\>#i", $break2, $s);
					
					$s = preg_replace("#" . $break2Quoted . "(\r\n)\<br \/\>#i", $break2, $s);
					
				}
				
				
				## Some other tags.
				$s = str_replace('</blockquote><br />', '</blockquote>' . "\n", $s);
				
				$s = str_replace('<br />' . "\r\n" . '<blockquote', "\n" . '<blockquote>', $s);
				
			} else {
				
				## If not, just simply clean!
				$s = str_replace('<br />', NULL, $s);
				
			}
			
			
			
			if($justParse) {
				
				echo $s;
				
			} else {
				
				return $s;
				
			}
			
			
			
			@eval($onShutdown);
			
		} ## Parse() is finally finished.
		
	} ## The ParserModule is finally finished.
	
	
	
	if ($_GET['smiley'] != "") {
	
		$parser = new parser;
	
		$parser->showSmileys();
	
	}
?>