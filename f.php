// WITH MAIL : PASSWORD OUTPUT
<?php

error_reporting(0);

class Filter{	
    public $email;
    public $password;

    public function filtering(){
        preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $this->email, $mailss);
        return $mailss[0][0];
    }

    public function passwordFilter($password){
        // Example password filter: at least 8 characters, including at least one number and one letter
        return preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password);
    }

    public function simpen($text, $nama){
        $xyz = fopen($nama, "a+");
        fwrite($xyz, "$text\n");
        fclose($xyz);
    }		

    public function misahin(){
        $filtering = $this->filtering();
        if($filtering){
            if (strstr($filtering, "@gmail") || strstr($filtering, "@googlemail")) {
                $this->simpen($filtering, "gmail_family.txt");
            }
            elseif(strstr($filtering, "@hotmail") || strstr($filtering, "@msn") || strstr($filtering, "@outlook") || strstr($filtering, "@live")) {
                $this->simpen($filtering, "hotmail_family.txt");
            }
            elseif(strstr($filtering, "@yahoo") || strstr($filtering, "@ymail")) {
                $this->simpen($filtering, "yahoo_family.txt");
            }
            elseif(strstr($filtering, "@aol")){
                $this->simpen($filtering, "aol_family.txt");
            }
            elseif(strstr($filtering, "@yandex")){
                $this->simpen($filtering, "yandex_family.txt");
            }
            else {
                $this->simpen($filtering, "other.txt");
            }

            if ($this->passwordFilter($this->password)) {
                $this->simpen($this->password, "valid_passwords.txt");
            } else {
                $this->simpen($this->password, "invalid_passwords.txt");
            }
        }
    }
}

$ngefilter = new Filter();

$mailist = readline("Your Mailist File: ");
echo "\n";
if (!file_exists($mailist)) die("!! File target ".$mailist." Not Found!!");

$list = explode("\n", file_get_contents($mailist));
$lines = count($list);

echo "Please Wait... ";

for ($i=0; $i<$lines; $i++) { 
    $parts = explode(":", $list[$i]);
    $ngefilter->email = $parts[0];
    $ngefilter->password = isset($parts[1]) ? $parts[1] : '';
    $ngefilter->misahin();
}

echo "DONE\n\n";
