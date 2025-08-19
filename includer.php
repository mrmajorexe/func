<?php
 
class Fungsi{
 
    const API = 'xxxxxxxxxxxxxxxxxxxxxxxxxx';
    const VERSION = 1;
 
    public static function curl($headers, $url, $head = null, $data = null){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        if ($data){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, true);
 
        $response = curl_exec($ch);
        //echo $response;
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        curl_close($ch);
        if($head == true){
            return $header;
        }elseif($head == false){
            file_put_contents("log.txt",$header.PHP_EOL.PHP_EOL.$body);
            return ["head" => base64_encode($header), "body" => base64_encode($body)];
        }elseif($head == 'res'){
            return $body;
        }
    }
    public static function curl2($headers, $url, $head = null, $data = null){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        //curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_3);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        if ($data){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, true);
 
        $response = curl_exec($ch);
        if ($response === false) { // Cek jika cURL gagal
            echo "cURL Error curl2: " . curl_error($ch); // Menampilkan pesan error
        }
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        curl_close($ch);
        if($head == true){
            return $header;
        }elseif($head == false){
            file_put_contents("log2.txt",$header.PHP_EOL.PHP_EOL.$body);
            return $body;
        }
    }
    public static function eco($text, $delay = 100000) {
        foreach (str_split($text) as $char) {
            echo $char;
            usleep($delay);
        }
    }
    public static function randomUserAgent() {
        $platforms = [
            'Windows NT 10.0', 'Windows NT 6.1', 'Windows NT 6.3', 'Macintosh; Intel Mac OS X 10_15_7',
            'X11; Ubuntu; Linux x86_64', 'X11; Fedora; Linux x86_64', 'Linux; Android 10', 'iPhone; CPU iPhone OS 14_6 like Mac OS X'
        ];
        $browsers = [
            'Chrome' => 'AppleWebKit/537.36 (KHTML, like Gecko) Chrome/',
            'Firefox' => 'Gecko/20100101 Firefox/',
            'Safari' => 'AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Safari/',
            'Edge' => 'AppleWebKit/537.36 (KHTML, like Gecko) Chrome/ Edg/',
            'Opera' => 'AppleWebKit/537.36 (KHTML, like Gecko) Chrome/ OPR/'
        ];
        $platform = $platforms[array_rand($platforms)];
        $browser = array_rand($browsers);
        $engine = $browsers[$browser];
        $browserVersion = rand(60, 99) . '.0.' . rand(1000, 4999) . '.' . rand(50, 150);
 
        if ($browser == 'Opera') {
            $browserVersion .= ' OPR/' . rand(60, 90) . '.0.' . rand(1000, 4999);
        } elseif ($browser == 'Edge') {
            $browserVersion .= ' Edg/' . rand(60, 90) . '.0.' . rand(1000, 4999);
        }
 
        $userAgent = "Mozilla/5.0 ($platform) $engine$browserVersion";
 
        return $userAgent;
    }
 
    public static function nama(){
        $ex = @file_get_contents("http://ninjaname.horseridersupply.com/indonesian_name.php");
        preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);
        $nama = @$name[2][mt_rand(0, 14) ];
        $contactname = @strtolower(explode(" ", $nama) [1]);

        $rpa = ["rudi","adiansyah","janoko","rusdi","mulyono","achmad","teguh","guntur","agussalim","suparman","susanto","fandi"];
        if($contactname == null){
            return $rpa[rand(0,11)];
        }
        return $contactname;
    }
 
    public static function check_vpn_and_os() {
        if (PHP_OS_FAMILY !== 'Linux') {
           // exit("Script ini hanya bisa dijalankan di os Linux!\n");
        }
        if(getcwd() !== '/data/data/com.termux/files/home'){
            //exit("Script ini hanya bisa dijalankan di Termux!\n");
        }
        $output = shell_exec("ifconfig tun0 2>&1");
        if (strpos($output, 'tun0') !== false) {
            exit("Script ini menolak penggunaan tunnel\n");
        }
    }
    public static function fake_email($nama, $domain, $check = NULL){

        $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.6778.86 Safari/537.36";
        $headers[] = "Cookie: surl=$domain/$nama;";
    
        if($check){
            $cek = Fungsi::curl2($headers,"https://email-fake.com/$domain/$nama",false);
            //file_put_contents("mail.txt",$cek);
            //$code = Fungsi::explo('letter-spacing: 8px">','</span>',$cek);
            //if (!is_numeric($code)) {
            //    return null;
            //}
            return $cek; //$code;
        }
    
        $headers[] = "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
        $buat = Fungsi::curl2($headers,"https://email-fake.com/check_adres_validation3.php",false,"usr=$nama&dmn=$domain");
        //echo $buat.PHP_EOL;
        if(Fungsi::parse($buat)['status'] != 'good'){
            //echo "email gagal dibuat\n";
            return NULL;
        }
        else{
            //echo "email: $nama@$domain";
            return "$nama@$domain";
        }
    }
 
    public static function random($n, $includeUppercase = false) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    
        if ($includeUppercase) {
            $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
    
        $randomString = '';
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
 
        return $randomString;
    }
 
 
    public static function gpt($teks){
        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key=" . self::API;
 
        while(true){
            $data = ["contents" => [["role" => "user","parts" => [["text" => $teks]]]]];
            $payload = json_encode($data);
            $response = fungsi::curl(['Content-Type: application/json'],$url,false,$payload);
 
            $pesan = json_decode($response,true)['candidates'][0]['content']['parts'][0]['text'];
            if($pesan == null){
                echo "\rAi tidak merespon -> mengulang permintaan\r";
                continue;
            }else{
                break;
            }
        }
        return $pesan;
    }
  
    public static function parse($var){
        return json_decode($var,true);
    }
    public static function pretty($var){
        return json_encode($var,JSON_PRETTY_PRINT);
    }
    public static function explo($str1, $str2, $var, $num = null){
        $key = $num ?? 1;
        $var1 = explode($str1,$var);
        $var2 = explode($str2,$var1[$key]);
 
        return $var2[0];
    }
    public static function timer($seconds) {
        $endTime = time() + $seconds;
 
        while (($remainingTime = $endTime - time()) > 0) {
            echo "\r\033[K";
            echo "\033[0;33mTunggu \033[1;37m" . gmdate('i:s', $remainingTime);
            flush();
            sleep(1);
        }
        echo "\r\033[K";
    }
 
 
}

?>
