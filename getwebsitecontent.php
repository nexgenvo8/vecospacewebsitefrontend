<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$url = trim($_REQUEST['url']);

if (strpos($url, "http://") !== false || strpos($url, "https://") !== false) {


	?>
	<script>
		$('#linkpasted').val('1');

	</script>


	<?php
	$contenttitle = '';

	// DO NOT modify URL protocol
$url = trim($url);


	// 🔹 Use a proper context to set user-agent (many sites block requests without it)
	$context = stream_context_create([
		'http' => [
			'method' => 'GET',
			'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
		]
	]);
function fetchUrl($url) {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

$finalurl = fetchUrl($url);
 // 🔹 @ suppresses warnings

	if ($finalurl === false || trim($finalurl) == '') {
		// 🔹 Avoid DOMDocument crash when HTML is empty
		$finalurl = '';
		$page_content = '';
		$title = '';
	} else {
		$page_content = $finalurl;

		libxml_use_internal_errors(true); // 🔹 Prevent HTML parsing warnings
		$dom_obj = new DOMDocument();
		$dom_obj->loadHTML($page_content, LIBXML_NOERROR | LIBXML_NOWARNING);
		libxml_clear_errors();
	}
	// 🔹 Suppress HTML parsing warnings

	$meta_val = null;
	$title = ''; // 🔹 Initialize variable
	$dom_obj = new DOMDocument();

	// Suppress warnings for malformed HTML
	libxml_use_internal_errors(true);

	if (!empty($link)) { // make sure your link variable exists
		$html = @file_get_contents($link);
		if ($html !== false) {
			$dom_obj->loadHTML($html);

			foreach ($dom_obj->getElementsByTagName('meta') as $meta) {
				if ($meta->getAttribute('property') == 'og:title') {
					$title = $meta->getAttribute('content');
				}
			}
		}
	}

	libxml_clear_errors();


	if ($title == '') {

		$pattern = "/<h1[^>]*>(.*?)<\/h1>/is";
		preg_match($pattern, $finalurl, $matches);
		if (!empty($matches[1])) {
			$contenttitle1 = $matches[1];
		}

		$pattern2 = "/<h2[^>]*>(.*?)<\/h2>/is";
		preg_match($pattern2, $finalurl, $matches2);
		if (!empty($matches2[1])) {
			$contenttitle2 = $matches2[1];
		}

		$pattern3 = "/<h3[^>]*>(.*?)<\/h3>/is";
		preg_match($pattern3, $finalurl, $matches3);
		if (!empty($matches3[1])) {
			$contenttitle3 = $matches3[1];
		}

		libxml_clear_errors(); // 🔹 Clean up any accumulated libxml errors



		$patterntitle = "/<title[^>]*>(.*?)<\/title>/is";
		preg_match($patterntitle, $finalurl, $matchestitle);

		$contenttitletitle = '';
		if (!empty($matchestitle[1])) {
			$contenttitletitle = trim($matchestitle[1]);
		}

		// Initialize variables to prevent "undefined" warnings
		$contenttitle1 = $contenttitle2 = $contenttitle3 = '';

		if (!empty($matches[1])) {
			$contenttitle1 = trim($matches[1]);
		}
		if (!empty($matches2[1])) {
			$contenttitle2 = trim($matches2[1]);
		}
		if (!empty($matches3[1])) {
			$contenttitle3 = trim($matches3[1]);
		}

		if ($contenttitle1 != '') {
			$title = $contenttitle1;
		} else if ($contenttitle2 != '') {
			$title = $contenttitle2;
		} else if ($contenttitle3 != '') {
			$title = $contenttitle3;
		} else if ($contenttitletitle != '') {
			$title = $contenttitletitle;
		}



	}


	$title = strip_tags($title);

	?>
	<div style="padding-bottom:10px; position:relative;">

		<a style="padding:5px 10px; background-color:#000; color:#FFFFFF; position:absolute; right:10px; top:10px;border-radius: 50%; text-decoration:none; cursor:pointer;"
			onclick="$('#websitecontentblock').html('');$('#websitecontentblock').hide();$('#linkpasted').val('0');">X</a>
		<div id="linkcontent">
			<div class="newsboxdiv">
				<a href="<?php echo trim($url); ?>"
				   >
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<?php
						$page_content = '';
						$imanadd = '';
						$title = '';
						$s = 0;

						$page_content = $finalurl;


						if (!empty($page_content)) {
							$dom_obj = new DOMDocument();
							libxml_use_internal_errors(true); // suppress HTML warnings
							$dom_obj->loadHTML($page_content);
							libxml_clear_errors();

							$meta_val = null;
							foreach ($dom_obj->getElementsByTagName('meta') as $meta) {
								if ($meta->getAttribute('property') == 'og:image') {
									$meta_val = $meta->getAttribute('content');
								}
								if ($meta->getAttribute('property') == 'og:title') {
									$title = $meta->getAttribute('content');
								}
							}
							$imanadd = $meta_val;
						}

						if (empty($imanadd) && !empty($page_content)) {
							$dom = new DOMDocument();
							libxml_use_internal_errors(true);

							$dom->loadHTML($page_content);
							$dom->preserveWhiteSpace = false;

							$images = $dom->getElementsByTagName('img');
							$imgarray = array();
							$type = array('jpg', 'jpeg', 'png', 'gif');

							foreach ($images as $img) {
								$src = $img->getAttribute('src');
								if (!empty($src)) {
									$imgarray[] = $src;
								}
							}

							foreach ($imgarray as $imageName) {
								if (preg_match('/logo|favicon|icon/i', $imageName)) {
								continue;
							}
								$ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
								if (in_array($ext, $type)) {
									$size = @getimagesize($imageName);
									if ($size) {
										list($width, $height) = $size;

										if ($width > 200) {
											$imanadd = $imageName;
											$s = 1;
										} elseif ($width > 150 && $s != 1) {
											$imanadd = $imageName;
											$s = 1;
										} elseif ($width > 100 && $s != 1) {
											$imanadd = $imageName;
											$s = 1;
										} elseif ($width > 50 && $s != 1) {
											$imanadd = 'noimage';
											$s = 1;
										}
									}
								}
							}
						}

						function GetDomain($url)
						{
							$nowww = preg_replace('/^www\./i', '', $url);
							$domain = parse_url($nowww);
							if (!empty($domain["host"])) {
								return $domain["host"];
							} elseif (!empty($domain["path"])) {
								return $domain["path"];
							} else {
								return $url;
							}
						}
						?>

						<?php if (!empty($imanadd) && $imanadd != 'noimage') { ?>
							<tr>
								<td>
									<div style="max-height:277px; overflow:hidden;">
										<div align="center">
											<img src="<?php echo $imanadd; ?>" style="max-width:100%; height:auto;">
										</div>
									</div>
								</td>
							</tr>
						<?php } ?>
						<tr>
							<td>
								<div style="padding:10px 0px;">
									<div style="margin-bottom:5px; font-size:15px; font-weight:bold; color:#1c267a;">
										<?php echo $title; ?>
									</div>
									<div style="text-transform:uppercase; font-size:10px; color:#999999;">
										<?php echo GetDomain($url); ?>
									</div>
								</div>
							</td>
						</tr>
					</table>
				</a>
			</div>
		</div>

		<textarea name="linkcontentsubmit" id="linkcontentsubmit" style="display:none;"></textarea>
		<input type="hidden" name="websiteshare" id="websiteshare" value="1" />
		<script>
			var linkcontent = $("#linkcontent").html();
			$("#linkcontentsubmit").val(linkcontent);
		</script>
	</div>


<?php } else { ?>
	<script>

		$('#websitecontentblock').html('');
		$('#websitecontentblock').hide();
	</script>

<?php } ?>