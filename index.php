<?php 
	/*Get Data From POST Http Request*/
	$datas = file_get_contents('php://input');
	/*Decode Json From LINE Data Body*/
	$deCode = json_decode($datas,true);
	file_put_contents('log.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);
	$replyToken = $deCode['events'][0]['replyToken'];
	$LINEDatas['url'] = "https://api.line.me/v2/bot/message/reply";
  	$LINEDatas['token'] = "5gZQWeN7r4W76y0rDoTq1kmZKNe0AHqZCoN0qKKUpVRyTg1qYcDk+9uvFzT0wOC1T6YhxwQ6qdRd7ld6Nnf/VT6rhFuPKAXakQ2gQazw/rDdeEmMASmG0i0wxPq5J9mT0CB1EQy2A2p+Bra2ayaa/AdB04t89/1O/w1cDnyilFU=";
  	$results = sentMessage($encodeJson,$LINEDatas);
	/*Return HTTP Request 200*/
	http_response_code(200);
	$dbconn = pg_connect("host=" . $GLOBALS['host'] . " port=5432 dbname=" . $GLOBALS['db'] . " user=" . $GLOBALS['user'] . " password=" . $GLOBALS['pass']) or die('Could not connect: ' . pg_last_error());
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
$Light = file_get_contents('https://api.thingspeak.com/channels/331361/fields/3/last.txt');
$water = file_get_contents('https://api.thingspeak.com/channels/331361/fields/4/last.txt');
$HUM = file_get_contents('https://api.thingspeak.com/channels/331361/fields/2/last.txt');
$TEM = file_get_contents('https://api.thingspeak.com/channels/331361/fields/1/last.txt');
$aba = ('https://i.imgur.com//yuRTcoH.jpg');
// convert
$sqlgetlastrecord = "select * from weatherstation order by \"DATETIME\" desc limit 1";
if (!is_null($events['events']))
{
	// Loop through each event
	foreach($events['events'] as $event)
	{
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text')
		{
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			// Build message to reply back
			$messages = ['type' => 'text', 'text' => "ยินดีต้อนรับคุณเข้าสูู่ แอปของเรา."."\n". "กรุณาพิมพ์ [H] เพื่อดูเมนูนะครับ 😊😊😊"."\n". "# ติดต่อAdminได้ที่https://www.facebook.com/AppCALWCH/"
			// "text"
			];
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "H")
			{
				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้"."\n"."\n"."[1] เว็บไซต์ทางการของการยางแห่งประเทศไทย"."\n"."[2] ข้อมูลข่าวสารเกี่ยวกับยางพารา" . "\n"."[3] ราคาปุ๋ยที่มีวางจำหน่ายในสหกรณ์การเกษตรจังหวัดตรัง" ."\n"."[4] ราคายาง" . "\n" . "[5] ราคาของปุ๋ยยางพาราที่ถูกที่สุดในช่วงอายุต่างๆ" . "\n"  . "[6] วิธีการผสมปุ๋ยใช้เอง"."\n"."[7] ตารางคำนวณสูตรปุ๋ยเคมียางพารา"."\n"."[8] ตารางคำนวณสูตรปุ๋ยอินทรีย์ยางพารา"."\n". "[9] ข้อมูลสภาพอากาศจากกรมอุตุนิยมวิทยา"."\n". "[10] กราฟกำหนดการเชิงเส้นแสดงต้นทุนที่ต่ำที่สุดของการใส่ปุ๋ยอินทรีย์ควบคู่กับปุ๋ยเคมี"."\n". "[11] แผนภูมิแท่งแสดงการเปรียบเทียบราคาของปุ๋ยเคมี ปุ๋ยผสม และปุ๋ยอินทรย์"."\n". "[M] เพื่อแสดงสถานที่ตั้งของหน่วยงานทางการเกษตร"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "4"){
				
				$messages = ['type' => 'text', 'text' => "ราคายางวันนี้ : " . "ข้อมูลจากการยางแห่งประเทศไทย" .  "\n" . "http://www.rubber.co.th/rubber2012/menu5.php"  .  "\n" . "[H] เพื่อดูเมนู"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "1"){
				
				$messages = ['type' => 'text', 'text' => "เว็บไซต์ทางการของการยางแห่งประเทศไทย " .  "\n" . "http://www.raot.co.th/main.php?filename=index." . "\n" . "[H] เพื่อดูเมนู"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "6"){
				
				$messages = ['type' => 'text', 'text' => "วิธีการผสมปุ๋ยใช้เอง : " . "ขอขอบคุณสำหรับข้อมูลจาก NanaGarden" .  "\n" . "https://www.nanagarden.com/topic/3829."  .  "\n" . "[H] เพื่อดูเมนู"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "3"){
				
				$messages = ['type' => 'text', 'text' => "ราคาปุ๋ย" .  "\n" . "https://docs.google.com/document/d/1CJaSBeO7fPn5N9c0lXvK2z7MOp6qqiL-WqSRVJ24dAg/edit."  .  "\n" . "[H] เพื่อดูเมนู"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "2"){
				
				$messages = ['type' => 'text', 'text' => "ดูข้อมูลข่าวสารเกี่ยวกับยางพารา"  .  "\n" . "http://www.raot.co.th/more_news.php?cid=10&filename=index/."  .  "\n" . "[H] เพื่อดูเมนู"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "7"){
				
				$messages = ['type' => 'text', 'text' => "ตารางคำนวณแม่ปุ๋ยเพื่อนำมาผสมใช้เอง" ."\n" . "คำนวณหาแม่ปุ๋ยมาผสมทำปุ๋ยโดยใช้ Microsoft Excel" .  "\n" ."\n" . "ตารางคำนวณแม่ปุ๋ยที่ต้องใช้ผสมสำหรับต้นยางพาราอายุ 1-2 ปี" . "\n" . "https://docs.google.com/spreadsheets/d/1yxyKW8J8k6Hdlef9rYIQ7JTLuCBkWy-OpdX2qwcgAOI/edit?usp=sharing" . "\n" . "ตารางคำนวณหาแม่ปุ๋ยที่ต้องใช้ผสมสำหรับต้นยางพาราอายุ 3-6 ปี" . "\n" . "https://docs.google.com/spreadsheets/d/1Q4aMY6mTPNjBixSWrLwJc2_mB-wQRN9JT9WAVRor_Yg/edit?usp=sharing" . "\n" . "ตารางคำนวณหาแม่ปุ๋ยที่ต้องนำมาผสมสำหรับต้นยางพาราอายุ 7-15 ปี" . "\n"  . "https://docs.google.com/spreadsheets/d/1LaqiA_QfwTmdsTpK0e-1zTmz9b_73B_FZyatD1CxaHA/edit?usp=sharing" . "\n" . "ตารางคำนวณหาแม่ปุ๋ยเพื่อนำมาผสมสำหรับต้นยางพาราอายุ 15 ปี ขึ้นไป" . "\n" . "https://docs.google.com/spreadsheets/d/1Isz8tFcyylk-i807Bz0uJOdBsARkvOutCrP47CAnOeI/edit?usp=sharing" . "\n" . "[H] เพื่อดูเมนู"];
			}
			 
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "5"){
				
				$messages = ['type' => 'text', 'text' => "ราคาปุ๋ยใส่ยางพาราที่ถูกที่สุดในช่วงอายุต่างๆ" ."\n" . "คำนวณหาราคาปุ๋ยที่ถุกที่สุดโดยวิธีเปรียบเทียบอัตราส่วน" .  "\n" . "https://docs.google.com/document/d/1xnbQIHYP_yboKn3CEE819JvgdpLwhJVhgp2aACyc-ww/edit"  .  "\n" . "[H] เพื่อดูเมนู"];
			}
	//EndCase
			if (trim(strtoupper($text)) == "a")
			{
				$messages = ['type' => 'text', 'text' => "a"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "a")
			{
				$messages = [
				'type' => 'text',
				'text' => "https://drive.google.com/open?id=14rP9TkpqLo3UwBcUzOu5zeoWu2tMp9eR"];
			}
			if (trim(strtoupper($text)) == "a")
			{
				$messages = ['type' => 'text', 'text' => "https://drive.google.com/open?id=14rP9TkpqLo3UwBcUzOu5zeoWu2tMp9eR"];
			}
			if ($text == "รูป")
			{
				$messages = ['type' => 'image', 'originalContentUrl' => "https://sv6.postjung.com/picpost/data/184/184340-1-2995.jpg", 'previewImageUrl' => "https://sv6.postjung.com/picpost/data/184/184340-1-2995.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "info")
			{
				$messages = ['type' => 'text', 'text' => "ยางพาราเป็นพืชเศรฐกิจไทย" ."\n"."อ่านเพิ่มเติม: https://th.wikipedia.org/wiki/%E0%B8%A2%E0%B8%B2%E0%B8%87%E0%B8%9E%E0%B8%B2%E0%B8%A3%E0%B8%B2"];
			}
				
			if ( ereg_replace('[[:space:]]+', '', trim($text)) == "O")
			{
				$rs = pg_query($dbconn, $sqlgetlastrecord) or die("Cannot execute query: $query\n");
				$templink = "";
				while ($row = pg_fetch_row($rs))
				{
					$templink = $row[1];
				}
				$messages = ['type' => 'image', 'originalContentUrl' => $templink, 'previewImageUrl' => $templink];
			}
			$textSplited = split(" ", $text);
			if ( ereg_replace('[[:space:]]+', '', trim($textSplited[0])) == "O")
			{
				$dataFromshowtime = showtime($textSplited[1]);
				$rs = pg_query($dbconn, $dataFromshowtime[1]) or die("Cannot execute query: $query\n");
				$templink = ""; 
				$qcount=0;
				while ($row = pg_fetch_row($rs))
				{
					$templink = $row[1];
					$qcount++;
				}
				//$messages = ['type' => 'text', 'text' => "HI $dataFromshowtime[0] \n$dataFromshowtime[1] \n$templink"
				if ($qcount > 0){
				$messages = [
				'type' => 'image',
				'originalContentUrl' => $templink,
					'previewImageUrl' => $templink
				];}
				else {
					$messages = [
						'type' => 'image',
						'originalContentUrl' => "https://imgur.com/aOWIijh.jpg",
							'previewImageUrl' => "https://imgur.com/aOWIijh.jpg" 
		
						];
				}
			}
			if ($text == "O")
			{
				$rs = pg_query($dbconn, $sqlgetlastrecord) or die("Cannot execute query: $query\n");
				$templink = "";
				while ($row = pg_fetch_row($rs))
				{
					$templink = $row[1];
				}
				$messages = ['type' => 'image', 'originalContentUrl' => $templink, 'previewImageUrl' => $templink];
			}
			
			/*if($text == "image"){
			$messages = [
			$img_url = "http://sand.96.lt/images/q.jpg";
			$outputText = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($img_url, $img_url);
			$response = $bot->replyMessage($event->getReplyToken(), $outputText);
			];
			}*/
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = ['replyToken' => $replyToken, 'messages' => [$messages], ];
			$post = json_encode($data);
			$headers = array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $access_token
			);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			echo $result . "\r\n";
		}
	}
}
echo "OK";
echo $date;
