<?php
/*
just for fun
*/
require_once('./line_class.php');
require_once('./unirest-php-master/src/Unirest.php');
$channelAccessToken = 'CkHhBC6Ambq9d3NOWNaZc2ymDU11L8tN/z94u6N0ySR8uKhVRExoPFxXa1IwezC2DKKBqaUPhaLLR4KGWtHsx5YZII5Agc75zchhL6pD7jVKwiqZaDZlQ2Gx2aVsYz12aKVnmwxOPR3p72AXU3ke1gdB04t89/1O/w1cDnyilFU='; //sesuaikan
$channelSecret = 'efdfb084093043e5c501fd0622a52319';//sesuaikan
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
$userId 	= $client->parseEvents()[0]['source']['userId'];
$groupId 	= $client->parseEvents()[0]['source']['groupId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$timestamp	= $client->parseEvents()[0]['timestamp'];
$type 		= $client->parseEvents()[0]['type'];
$message 	= $client->parseEvents()[0]['message'];
$messageid 	= $client->parseEvents()[0]['message']['id'];
$profil = $client->profil($userId);
$pesan_datang = explode(" ", $message['text']);
$msg_type = $message['type'];
$command = $pesan_datang[0];
$options = $pesan_datang[1];
if (count($pesan_datang) > 2) {
    for ($i = 2; $i < count($pesan_datang); $i++) {
        $options .= '+';
        $options .= $pesan_datang[$i];
    }
}
#-------------------------[Function]-------------------------#
function instainfo($keyword) {
    $uri = "https://www.instagram.com/" . $keyword . "/?__a=1";
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result['atas']      .= $json["graphql"]["user"]["profile_pic_url_hd"];
    $result['nama']      .= $json['graphql']['user']['full_name'];
    $result['username']  .= $json['graphql']['user']['username'];
    $result['followers'] .= $json["graphql"]["user"]["edge_followed_by"]["count"];
    $result['following'] .= $json["graphql"]["user"]["edge_follow"]["count"];
    $result['private']   .= $json["graphql"]["user"]["is_private"];
    $result['totalpost'] .= $json["graphql"]["user"]["edge_owner_to_timeline_media"]["count"];
    $result['bio']       .= $json['graphql']['user']['biography'];
    $result['bawah']     .= 'https://www.instagram.com/'. $keyword;
    
    return $result;
}
function textspech($keyword) {
    $uri = "https://farzain.xyz/api/tts.php?apikey=9YzAAXsDGYHWFRf6gWzdG5EQECW7oo&id=" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result .= $json['result'];
    return $result;
}
function cloud($keyword) {
    $uri = "https://farzain.xyz/api/premium/soundcloud.php?apikey=ag73837ung43838383jdhdhd&id=" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    
    $result['id']    .= $json['result'][0]['id'];
    $result['judul'] .= $json['result'][0]['title'];
    $result['link']  .= $json['result'][0]['url'];
    $result['audio'] .= $json['result'][0]['url_download'];
    $result['icon']  .= $json['result'][0]['img'];
	
    return $result;
}
function musiknya($keyword) {
    $uri = "https://farzain.xyz/api/premium/joox.php?apikey=ag73837ung43838383jdhdhd&id=" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result = "「Music Result」\n";
    $result .= "\n\nPenyanyinya: ";
	  $result .= $json['info']['penyanyi'];
    $result .= "\n\nJudulnya: ";
    $result .= $json['info']['judul'];
    $result .= "\n\nAlbum: ";
    $result .= $json['info']['album'];
    $result .= "\nMp3: \n";
    $result .= $json['audio']['mp3'];
    $result .= "\n\nM4a: \n";
    $result .= $json['audio']['m4a'];
    $result .= "\n\nIcon: \n";
    $result .= $json['gambar'];
    $result .= "\n\nLirik: \n";
    $result .= $json['lirik'];
    return $result;
}
function fansign($keyword) {
    $uri = "https://farzain.xyz/api/premium/fs.php?apikey=ag73837ung43838383jdhdhd&id=" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
	  $result .= $json['url'];
    return $result;
}
function saveitoffline($keyword) {
    $uri = "https://www.saveitoffline.com/process/?url=" . $keyword . '&type=json';
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
	$result = "====[SaveOffline]====\n";
	$result .= "Judul : \n";
	$result .= $json['title'];
	$result .= "\n\nUkuran : \n";
	$result .= $json['urls'][0]['label'];
	$result .= "\n\nURL Download : \n";
	$result .= $json['urls'][0]['id'];
	$result .= "\n\nUkuran : \n";
	$result .= $json['urls'][1]['label'];
	$result .= "\n\nURL Download : \n";
	$result .= $json['urls'][1]['id'];
	$result .= "\n\nUkuran : \n";
	$result .= $json['urls'][2]['label'];	
	$result .= "\n\nURL Download : \n";
	$result .= $json['urls'][2]['id'];
	$result .= "\n\nUkuran : \n";
	$result .= $json['urls'][3]['label'];	
	$result .= "\n\nURL Download : \n";
	$result .= $json['urls'][3]['id'];	
	$result .= "\n\nPencarian : Google\n";
    return $result;
}
function jadwaltv($keyword) {
    $uri = "https://farzain.xyz/api/premium/acaratv.php?apikey=ag73837ung43838383jdhdhd&id=" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result = "「TV Schedule」";
	  $result .= $json['url'];
    return $result;
}
function shalat($keyword) {
    $uri = "https://time.siswadi.com/pray/" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result = "「Praytime Schedule」\n\n";
	  $result .= $json['location']['address'];
	  $result .= "\nTanggal : ";
	  $result .= $json['time']['date'];
	  $result .= "\n\nShubuh : ";
	  $result .= $json['data']['Fajr'];
	  $result .= "\nDzuhur : ";
	  $result .= $json['data']['Dhuhr'];
	  $result .= "\nAshar : ";
	  $result .= $json['data']['Asr'];
	  $result .= "\nMaghrib : ";
	  $result .= $json['data']['Maghrib'];
	  $result .= "\nIsya : ";
	  $result .= $json['data']['Isha'];
    return $result;
}
function cuaca($keyword) {
    $uri = "http://api.openweathermap.org/data/2.5/weather?q=" . $keyword . ",ID&units=metric&appid=e172c2f3a3c620591582ab5242e0e6c4";
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result = "「Weather Result」";
    $result .= "\n\nNama kota:";
	  $result .= $json['name'];
	  $result .= "\n\nCuaca : ";
	  $result .= $json['weather']['0']['main'];
	  $result .= "\nDeskripsi : ";
	  $result .= $json['weather']['0']['description'];
    return $result;
}
function waktu($keyword) {
    $uri = "https://farzain.xyz/api/jam.php?apikey=9YzAAXsDGYHWFRf6gWzdG5EQECW7oo&id=" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result['a'] .= "「Time Result」\n";
    $result['b'] .= "\nNama kota: ";
    $result['c'] .= $json['location']['address'];
    $result['d'] .= "\nZona waktu: ";
    $result['e'] .= $json['time']['timezone'];
    $result['f'] .= "\nWaktu: \n";
    $result['g'] .= $json['time']['time'];
    $result['h'] .= "\n";
    $result['i'] .= $json['time']['date'];
    return $result;
}
function manga($keyword) {
    $fullurl = 'https://myanimelist.net/api/manga/search.xml?q=' . $keyword;
    $username = 'jamal3213';
    $password = 'FZQYeZ6CE9is';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_URL, $fullurl);
    $returned = curl_exec($ch);
    $xml = new SimpleXMLElement($returned);
    $parsed = array();
    $parsed['id'] = (string) $xml->entry[0]->id;
    $parsed['image'] = (string) $xml->entry[0]->image;
    $parsed['title'] = (string) $xml->entry[0]->title;
    $parsed['desc'] = "Episode : ";
    $parsed['desc'] .= $xml->entry[0]->episodes;
    $parsed['desc'] .= "\nNilai : ";
    $parsed['desc'] .= $xml->entry[0]->score;
    $parsed['desc'] .= "\nTipe : ";
    $parsed['desc'] .= $xml->entry[0]->type;
    $parsed['synopsis'] = str_replace("<br />", "\n", html_entity_decode((string) $xml->entry[0]->synopsis, ENT_QUOTES | ENT_XHTML, 'UTF-8'));
    return $parsed;
}
function anime($keyword) {
    $fullurl = 'https://myanimelist.net/api/anime/search.xml?q=' . $keyword;
    $username = 'jamal3213';
    $password = 'FZQYeZ6CE9is';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_URL, $fullurl);
    $returned = curl_exec($ch);
    $xml = new SimpleXMLElement($returned);
    $parsed = array();
    $parsed['id'] = (string) $xml->entry[0]->id;
    $parsed['image'] = (string) $xml->entry[0]->image;
    $parsed['title'] = (string) $xml->entry[0]->title;
    $parsed['desc'] = "Episode : ";
    $parsed['desc'] .= $xml->entry[0]->episodes;
    $parsed['desc'] .= "\nNilai : ";
    $parsed['desc'] .= $xml->entry[0]->score;
    $parsed['desc'] .= "\nTipe : ";
    $parsed['desc'] .= $xml->entry[0]->type;
    $parsed['synopsis'] = str_replace("<br />", "\n", html_entity_decode((string) $xml->entry[0]->synopsis, ENT_QUOTES | ENT_XHTML, 'UTF-8'));
    return $parsed;
}
function lokasi($keyword) { 
    $uri = "https://time.siswadi.com/pray/" . $keyword; 
 
    $response = Unirest\Request::get("$uri"); 
 
    $json = json_decode($response->raw_body, true); 
 $result['address'] .= $json['location']['address'];
 $result['latitude'] .= $json['location']['latitude'];
 $result['longitude'] .= $json['location']['longitude'];
    return $result; 
}
function send($input, $rt){
    $send = array(
        'replyToken' => $rt,
        'messages' => array(
            array(
                'type' => 'text',					
                'text' => $input
            )
        )
    );
    return($send);
}
function jawabs(){
    $list_jwb = array(
		'Ya',
	        'Bisa jadi',
	        'Mungkin',
	        'Gak tau',
	        'Woya donk',
	        'Jawab gk yah!',
		'Tidak',
		'Coba ajukan pertanyaan lain',	    
		);
    $jaws = array_rand($list_jwb);
    $jawab = $list_jwb[$jaws];
    return($jawab);
}
#-------------------------[Function]-------------------------#
# require_once('./src/function/search-1.php');
# require_once('./src/function/download.php');
# require_once('./src/function/random.php');
# require_once('./src/function/search-2.php');
# require_once('./src/function/hard.php');
if ($type == 'join') {
    $text = "Makasih dh invite aku ke grup kak!! Ketik /menu untuk melihat fitur yang aq punya\n\n";
    $text .= "untuk menggunakan fitur secara maksimal add aq dulu y kak :)\n";
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );
}
//show menu, saat join dan command /menu
if ($command == '/menu') {
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
          array (
  'type' => 'template',
  'altText' => 'Anda di sebut',
  'template' =>
  array (
    'type' => 'carousel',
    'columns' =>
    array (
      0 =>
      array (
        'thumbnailImageUrl' => 'https://example.com/bot/images/item2.jpg',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'Soundcloud',
        'text' => 'Mencari Dan Unduh Musik Di SoundCloud',
        'defaultAction' =>
        array (
          'type' => 'uri',
          'label' => 'View detail',
          'uri' => 'http://example.com/page/123',
        ),
        'actions' =>
        array (
          0 =>
          array (
            'type' => 'message',
            'label' => 'Detail',
            'text' => 'Ketik /soundcloud ......',
          ),
        ),
      ),
      1 =>
      array (
        'thumbnailImageUrl' => 'https://example.com/bot/images/item2.jpg',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'Instagram',
        'text' => 'Menemukan Informasi Akun Instagram Berdasarkan Keyword',
        'defaultAction' =>
        array (
          'type' => 'uri',
          'label' => 'View detail',
          'uri' => 'http://example.com/page/123',
        ),
        'actions' =>
        array (
          0 =>
          array (
            'type' => 'message',
            'label' => 'Detail',
            'text' => 'Ketik /instagram ......',
          ),
        ),
      ),
      2 =>
      array (
        'thumbnailImageUrl' => 'https://example.com/bot/images/item2.jpg',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'Anime',
        'text' => 'Mencari Informasi Anime Berdasarkan Keyword',
        'defaultAction' =>
        array (
          'type' => 'uri',
          'label' => 'View detail',
          'uri' => 'http://example.com/page/123',
        ),
        'actions' =>
        array (
          0 =>
          array (
            'type' => 'message',
            'label' => 'Detail',
            'text' => 'ketik /anime ......',
          ),
        ),
      ),
      3 =>
      array (
        'thumbnailImageUrl' => 'https://example.com/bot/images/item2.jpg',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'Praytime',
        'text' => 'Mengetahui Jadwal Shalat Wilayah Indonesia Berdasarkan Tempat',
        'defaultAction' =>
        array (
          'type' => 'uri',
          'label' => 'View detail',
          'uri' => 'http://example.com/page/123',
        ),
        'actions' =>
        array (
          0 =>
          array (
            'type' => 'message',
            'label' => 'Detail',
            'text' => 'Ketik /shalat ......',
          ),
        ),
      ),
      4 =>
      array (
        'thumbnailImageUrl' => 'https://example.com/bot/images/item2.jpg',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'Fansign',
        'text' => 'Membuat FS Anime Berdasarkan Keyword',
        'defaultAction' =>
        array (
          'type' => 'uri',
          'label' => 'View detail',
          'uri' => 'http://example.com/page/123',
        ),
        'actions' =>
        array (
          0 =>
          array (
            'type' => 'message',
            'label' => 'Detail',
            'text' => 'Ketik /fansign ......',
          ),
        ),
      ),
      5 =>
      array (
        'thumbnailImageUrl' => 'https://example.com/bot/images/item2.jpg',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'IndoXXI',
        'text' => 'Cari Film Di IndoXXI',
        'defaultAction' =>
        array (
          'type' => 'uri',
          'label' => 'View detail',
          'uri' => 'http://example.com/page/123',
        ),
        'actions' =>
        array (
          0 =>
          array (
            'type' => 'message',
            'label' => 'Detail',
            'text' => 'Ketik /film ......',
          ),
        ),
      ),
      6 =>
      array (
        'thumbnailImageUrl' => 'https://example.com/bot/images/item2.jpg',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'Television',
        'text' => 'Mencari Jadwal Acara Televisi Indonesia',
        'defaultAction' =>
        array (
          'type' => 'uri',
          'label' => 'View detail',
          'uri' => 'http://example.com/page/123',
        ),
        'actions' =>
        array (
          0 =>
          array (
            'type' => 'message',
            'label' => 'Detail',
            'text' => 'Ketik /jadwaltv ......',
          ),
        ),
      ),
      7 =>
      array (
        'thumbnailImageUrl' => 'https://example.com/bot/images/item2.jpg',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'Music',
        'text' => 'Mengunduh Musik Dari Joox Dengan Lirik',
        'defaultAction' =>
        array (
          'type' => 'uri',
          'label' => 'View detail',
          'uri' => 'http://example.com/page/123',
        ),
        'actions' =>
        array (
          0 =>
          array (
            'type' => 'message',
            'label' => 'Detail',
            'text' => 'ketik /joox ......',
          ),
        ),
      ),
      8 =>
      array (
        'thumbnailImageUrl' => 'https://example.com/bot/images/item2.jpg',
        'imageBackgroundColor' => '#00FFFF',
        'title' => 'Weather',
        'text' => 'Mengetahui Prakiraan Cuaca Seluruh Dunia',
        'defaultAction' =>
        array (
          'type' => 'uri',
          'label' => 'View detail',
          'uri' => 'http://example.com/page/222',
        ),
        'actions' =>
        array (
          0 =>
          array (
            'type' => 'message',
            'label' => 'Detail',
            'text' => 'Ketik /cuaca ......',
          ),
        ),
      ),
    ),
    'imageAspectRatio' => 'rectangle',
    'imageSize' => 'cover',
  ),
)
)
);
}

//pesan khusus
if($message['type']=='text') {
	    if ($command == '/lokasi' || $command == '/Lokasi') {
        $result = lokasi($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'location',
                    'title' => 'Lokasi',
                    'address' => $result['address'],
                    'latitude' => $result['latitude'],
                    'longitude' => $result['longitude']
                ),
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/soundcloud') {
        $result = cloud($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
		    array(
                  'type' => 'image',
                  'originalContentUrl' => $result['icon'],
                  'previewImageUrl' => $result['icon']
                ),
                array(
                    'type' => 'text',
                    'text' => 'ID: '.$result['id'].'
TITLE: '. $result['judul'].'
URL: '. $result['link']
                ),
		    array(
                  'type' => 'audio',
                  'originalContentUrl' => $result['audio'],/*link https only and format m4a*/
                  'duration' => 60000
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/instagram') {
        $result = instainfo($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
		array(
                  'type' => 'image',
                  'originalContentUrl' => $result['atas'],
                  'previewImageUrl' => $result['atas']
                ),
                array(
                    'type' => 'text',
                    'text' =>  
			      '「Instagram Result」'.'
'.'
Name: '.$result['nama'].'
Username: '.$result['username'].'
Follower: '.$result['followers'].'
Following: '.$result['following'].'
Private: '.$result['private'].'
Total post: '.$result['totalpost'].'
Bio:
'.$result['bio'].'
'.
$result['bawah']
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/anime') {
        $result = anime($options);
        $altText = "Title : " . $result['title'];
        $altText .= "\n\n" . $result['desc'];
        $altText .= "\nMAL Page : https://myanimelist.net/anime/" . $result['id'];
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'template',
                    'altText' => $altText,
                    'template' => array(
                        'type' => 'buttons',
                        'title' => $result['title'],
                        'thumbnailImageUrl' => $result['image'],
                        'text' => $result['desc'],
                        'actions' => array(
                            array(
                                'type' => 'postback',
                                'label' => 'Baca Sinopsis-nya',
                                'data' => 'action=add&itemid=123',
                                'text' => '/anime-syn ' . $options
                            ),
                            array(
                                'type' => 'uri',
                                'label' => 'Website MAL',
                                'uri' => 'https://myanimelist.net/anime/' . $result['id']
                            )
                        )
                    )
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/manga') {
        $result = manga($options);
        $altText = "Title : " . $result['title'];
        $altText .= "\n\n" . $result['desc'];
        $altText .= "\nMAL Page : https://myanimelist.net/manga/" . $result['id'];
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'template',
                    'altText' => $altText,
                    'template' => array(
                        'type' => 'buttons',
                        'title' => $result['title'],
                        'thumbnailImageUrl' => $result['image'],
                        'text' => $result['desc'],
                        'actions' => array(
                            array(
                                'type' => 'postback',
                                'label' => 'Baca Sinopsis-nya',
                                'data' => 'action=add&itemid=123',
                                'text' => '/manga-syn' . $options
                            ),
                            array(
                                'type' => 'uri',
                                'label' => 'Website MAL',
                                'uri' => 'https://myanimelist.net/manga/' . $result['id']
                            )
                        )
                    )
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/gtts') {
        $result = textspech($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                  'type' => 'audio',
                  'originalContentUrl' => $result,/*link https only and format m4a*/
                  'duration' => 60000
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/musik') {
        $result = musiknya($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/gambar') {
        $result = gambarnya($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                  'type' => 'image',
                  'originalContentUrl' => $jawab,
                  'previewImageUrl' => $jawab
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/fansign') {
        $result = fansign($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'image',
                    'originalContentUrl' => $result,
                    'previewImageUrl' => $result
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/jadwaltv') {
        $result = jadwaltv($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/shalat') {
        $result = shalat($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/cuaca') {
        $result = cuaca($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
if (isset($balas)) {
    $result = json_encode($balas);
//$result = ob_get_clean();
    file_put_contents('./balasan.json', $result);
    $client->replyMessage($balas);
}
?>
