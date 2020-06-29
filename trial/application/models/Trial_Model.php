<?php
require APPPATH . "trial_libraries/aws-autoloader.php";

use Aws\Route53\Route53Client;
use Aws\Exception\CredentialsException;
use Aws\Route53\Exception\Route53Exception;
use Aws\S3\S3Client;
use Aws\S3\Transfer;

include( APPPATH . 'trial_libraries/phpseclib/Net/SFTP.php');
include( APPPATH . 'trial_libraries/phpseclib/Crypt/RSA.php');


defined('BASEPATH') OR exit('No direct script access allowed');
class Trial_Model extends CI_Controller {

    

    function __construct(){
        parent::__construct();
    }

	public function verifySubdomainAvaiable($subDomainName){
        //To build connection
        try {
       

            $client = Route53Client::factory(array(
                'region' => 'us-east-1', //region aws  
                'version' => 'latest',   // eg. latest or 2013-04-01   
                'credentials' => [
                    'key' => 'AKIA5AQZS5JMAWUELDG7',
                    'secret' => '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',
                ]
            ));       


            $result = $client->listResourceRecordSets(array(
                // HostedZoneId is required
                'HostedZoneId' => 'Z09209142EL69AWNKFWV4'            
            ));

            $subDomainsObj = $result['ResourceRecordSets'];
            $unvaiableNames = array(
                'system',
                'eadcenter',
                'application', 
                'assets', 
                'cgi-bin', 
                'otphp', 
                'version',
                'trial'
            ); 
            foreach($subDomainsObj as $data){  
                if (!in_array($data['Name'], $unvaiableNames)) { 
                    $unvaiableNames[] = str_replace(".sabiorealm.com.","", $data['Name']); 
                }
            }

            if(in_array($subDomainName, $unvaiableNames)){
                return false;
            }else{
                return true;
            }
        
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }

    }

    public function createTrial($userName,$userPhone,$userEmail,$userPassword,$subDomainName,$step,$goal,$token){
       
        /* RDS SERVER */
        $serverNameRds = "sabiorealm.cvazuf0euqlw.us-east-1.rds.amazonaws.com";
        $userNameRds = "admin";
        $passwordRds = "k4=IO#d33Sb2";
        
        /* CLIENT */
        $client = Route53Client::factory(array(
            'region' => 'us-east-1', //region aws  
            'version' => 'latest',   // eg. latest or 2013-04-01   
            'credentials' => [
                'key' => 'AKIA5AQZS5JMAWUELDG7',
                'secret' => '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',
            ]
        )); 

        $s3Client = new Aws\S3\S3Client([
            'version' => 'latest',
            'region' => 'us-east-1',
            'credentials' => [
                'key' => 'AKIA5AQZS5JMAWUELDG7',
                'secret' =>'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',
            ],
        ]);

        //$this->createNewSubDomain($subDomainName,$client);

        //$this->createNewDataBase($serverNameRds,$userNameRds,$passwordRds,$subDomainName);
        //$this->createTables($serverNameRds,$userNameRds,$passwordRds,$subDomainName);
        //$this->insertIntoDataBase($serverNameRds,$userNameRds,$passwordRds,$subDomainName,$userEmail,$userName,$userPassword,$userPhone,$step,$goal,$token);
        //$this->saveInformationIntoDb($serverNameRds,$userNameRds,$passwordRds,$subDomainName,$userEmail,$userName,$userPhone,$step,$goal);

        //$this->moveLmsFiles($subDomainName);
        //$this->changeConfigFiles($subDomainName);
        //$this->createHtaccess($subDomainName);
       // $this->createDirectoryStructureInS3($subDomainName, $s3Client);
        //$this->moveDummyFiles($subDomainName, $s3Client);


       // $this->createCronJob($subDomainName);
        //$this->createConfigSubdomainFile($subDomainName);

        $this->sendWelcomeEmail($subDomainName,$userName,$userPassword,$userEmail);
        $this->sendTrialEmail($subDomainName,$userName,$userEmail,$userPhone,$step,$goal);
        
        return true;
    }

    private function saveInformationIntoDb($serverNameRds,$userNameRds,$passwordRds,$subDomainName,$userEmail,$userName,$userPhone,$step,$goal){
        $dbName = "sbr_admin";
        try {
            $conn = new PDO("mysql:host=$serverNameRds;dbname=$dbName", $userNameRds, $passwordRds);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }

        catch(Exception $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
        }

        /*  Insert into trials */
        $rowsToInsert = array(
            array(
                'create_date' => date("Y-m-d"),
                'domain' => $subDomainName,
                'country' => $this->getUserCountry(),
                'contact_name' => $userName,
                'contact_email' => $userEmail,
                'phone' => $userPhone,
                'step_project' => $step,
                'type_project' => $goal,
                'expiration_date' => date("Y-m-d", strtotime("+7 days")),
            )
        );
        $this->pdoMultiInsert('trials', $rowsToInsert, $conn);
    }

    private function connectSsh(){
        $ssh = new Net_SFTP("67.202.14.58");
        $key = new Crypt_RSA();
        $key->loadKey(file_get_contents(APPPATH . 'trial_libraries/sabiorealm_production.pem'));
        if (!$ssh->login("centos", $key)) {
            exit('Login Failed');
        }else{
            return $ssh;
        }
    }

    private function createDirectoryStructureInS3($subDomainName,$s3Client){
        $data = array(
            $subDomainName . '/index.html',
            $subDomainName . '/uploads/index.html',
            $subDomainName . '/uploads/answers/index.html',
            $subDomainName . '/uploads/avatar/index.html',
            $subDomainName . '/uploads/answers/index.html',
            $subDomainName . '/uploads/builder/index.html',
            $subDomainName . '/uploads/builder/body/index.html',
            $subDomainName . '/uploads/builder/header/index.html',
            $subDomainName . '/uploads/content/index.html',
            $subDomainName . '/uploads/course/index.html',
            $subDomainName . '/uploads/flags/index.html',
            $subDomainName . '/uploads/html/index.html',
            $subDomainName . '/uploads/preview/index.html',
            $subDomainName . '/uploads/program/index.html',
            $subDomainName . '/uploads/question/index.html',
            $subDomainName . '/uploads/settings/index.html',
            $subDomainName . '/uploads/testimonial/index.html',
        );

        $this->createObjIntoBucket($data,$s3Client);    
    }


    private function createObjIntoBucket($ar, $s3Client){
        foreach($ar as $dir){
            $s3Client->putObject(array(
                'Bucket' => 'sabiorealm', 
                'Key' => $dir, 
                'ACL' => 'public-read' 
            ));
        }
    }

    private function moveDummyFiles($subDomainName,$s3Client){
       

        $data = array(
            array(
               "sourceKeyName" => "uploads/avatar/default.png",
               "targetKeyName" => $subDomainName . "/uploads/avatar/default.png"
            ),
            array(
                "sourceKeyName" => "uploads/builder/body/default_banner.png",
                "targetKeyName" => $subDomainName . "/uploads/builder/body/default_banner.png"
            ),
            array(
                "sourceKeyName" => "uploads/builder/body/default_text_and_media.mp4",
                "targetKeyName" => $subDomainName . "/uploads/builder/body/default_text_and_media.mp4"
            ),
            array(
                "sourceKeyName" => "uploads/builder/body/default_text_and_media.png",
                "targetKeyName" => $subDomainName . "/uploads/builder/body/default_text_and_media.png"
            ),
            array(
                "sourceKeyName" => "uploads/builder/header/sabiorealm.png",
                "targetKeyName" => $subDomainName . "/uploads/builder/header/sabiorealm.png"
            ),
            array(
                "sourceKeyName" => "uploads/flags/en.png",
                "targetKeyName" => $subDomainName . "/uploads/flags/en.png"
            ),
            array(
                "sourceKeyName" => "uploads/flags/es.png",
                "targetKeyName" => $subDomainName . "/uploads/flags/es.png"
            ),
            array(
                "sourceKeyName" => "uploads/flags/pt-br.png",
                "targetKeyName" => $subDomainName . "/uploads/flags/pt-br.png"
            ),
            array(
                "sourceKeyName" => "uploads/settings/favicon.png",
                "targetKeyName" => $subDomainName . "/uploads/settings/favicon.png"
            ),
            array(
                "sourceKeyName" => "uploads/settings/sabiorealm.png",
                "targetKeyName" => $subDomainName . "/uploads/settings/sabiorealm.png"
            ),
            array(
                "sourceKeyName" => "uploads/testimonial/tom.png",
                "targetKeyName" => $subDomainName . "/uploads/testimonial/tom.png"
            ),
        );

        $this->copyFiles($data,$s3Client);
      
    }


    private function copyFiles($ar,$s3Client){
        $sourceBucket = 'sbrdummy';
        $targetBucket = 'sabiorealm';

        foreach($ar as $data){
        
            $sourceKeyname = $data["sourceKeyName"];
            $targetKeyname = $data["targetKeyName"];
            
            $s3Client->copyObject(array(
                'Bucket'     => $targetBucket,
                'Key'        => $targetKeyname,
                'CopySource' => "{$sourceBucket}/{$sourceKeyname}",
            ));
        }
    
    }

    private function sendTrialEmail($subDomainName, $userName, $userEmail, $userPhone, $step, $goal){
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-east-1.amazonaws.com',
            'smtp_port' => '587',
            'smtp_user' => 'AKIA5AQZS5JMHZJQEYNS',
            'smtp_pass' => 'BA9wv96UyVOcVULCn30pqz2WdBzBKAbl/RLO7fjiQKB1',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );


        $data = array(
            'subdomainName' => $subDomainName,
            'userName' => $userName,
            'userEmail' => $userEmail,
            'userPhone' => $userPhone,
            'country' => $this->getUserCountry(),
            'goal' => $goal,
            'step' => $step,
            'date' => date("d/m/Y")
        );

        $this->load->library('email', $config);
        $mesg = $this->load->view('emails/new_trial', $data, true);
        $this->email->from('noreply@sabiorealm.com', "Sabiorealm");
        $this->email->to('trial@sabiorealm.com');
        $this->email->subject("New trial!");
        $this->email->message($mesg);
        $this->email->send();
    }


    private function sendWelcomeEmail($subDomainName, $userName,$userPassword, $userEmail){
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.sabiorealm.com',
            'smtp_user' => 'noreply@sabiorealm.com',
            'smtp_pass' => '5S=P0BT*SwA=C<F&!5J]?}jN@',
            'smtp_port' => '587',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
        );


        $data = array(
            'subdomainName' => $subDomainName,
            'userName' => $userName,
            'userEmail' => $userEmail,
            'userPassword' => $userPassword,
            'url' => "https://{$subDomainName}.sabiorealm.com"
        );

        $this->load->library('email', $config);
        $mesg = $this->load->view('emails/first_email', $data, true);
        $this->email->from('noreply@sabiorealm.com', "Sabiorealm");
        $this->email->to($userEmail);
        $this->email->subject("¡Tu escuela ha sido creada!");
        $this->email->message($mesg);
        print_r($this->email->send());
    }

    private function createNewSubDomain($subDomainName,$client){
        $name = $subDomainName . ".sabiorealm.com.";   
        $dns = 'sabiorealm-1587147781.us-east-1.elb.amazonaws.com'; 
        $ResourceRecordsValue = array('Value' => $dns);
    
        $client->changeResourceRecordSets([
            'ChangeBatch'  => [
                'Changes' => [
                    [
                        'Action'            => 'CREATE',
                        "ResourceRecordSet" => [
                            'Name'            => $name,
                            'Type'            => 'CNAME',
                            'TTL'             => '300',
                            'ResourceRecords' => [
                                $ResourceRecordsValue
                            ]
                        ]
                    ]
                ]
            ],
            'HostedZoneId' => 'Z09209142EL69AWNKFWV4'
        ]);
    }

    private function createNewDataBase($serverName,$userName,$password,$subDomainName){
        $dbName = "sbr_{$subDomainName}";     

        try {
            $conn = new PDO("mysql:host=$serverName", $userName, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE DATABASE " . $dbName . "; ";
            $sql .= "USE " . $dbName . "; ";
            $sql .= "GRANT CREATE,DELETE,SELECT,INSERT,ALTER,UPDATE,REFERENCES ON " . $dbName . " TO '" . $userName . "'@'%' WITH GRANT OPTION; ";
            $conn->exec($sql);
            $conn = null;    
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

    private function moveLmsFiles($subDomainName){

        /* Ssh connection */
        $ssh = $this->connectSsh();
       
        /* Create a new directory */
        $ssh->exec("cd /var/www/html;mkdir {$subDomainName}");

        /* Move files */
        print_r($ssh->exec("cp -R /home/centos/released/* /var/www/html/{$subDomainName}"));

    }

    private function changeConfigFiles($subDomainName){
        $ssh = $this->connectSsh();

        $dbName = "sbr_{$subDomainName}";

        $ssh->exec('sed -i "s/defaulturl/'.$subDomainName.'/g" /var/www/html/'.$subDomainName.'/application/config/config.php');

        $ssh->exec('sed -i "s/defaultdb/'.$dbName.'/g" /var/www/html/'.$subDomainName.'/application/config/database.php');
    }

    private function createCronJob($subDomainName){
        $ssh = $this->connectSsh();

        $ssh->exec("(crontab -l ; echo '0 0 * * * php -f /var/www/html/{$subDomainName}/index.php payment verify_payments') | crontab");
    }

    private function createHtaccess($subDomainName){
        $ssh = $this->connectSsh();
        print_r($ssh->exec('echo "
            
            <IfModule mod_rewrite.c>
                RewriteEngine On
                RewriteCond %{REQUEST_FILENAME} !-f 
                RewriteCond %{REQUEST_FILENAME} !-d
                RewriteRule ^(.*)$ index.php/$1 [L]
            </IfModule>
                    
             " >> /var/www/html/'.$subDomainName.'/.htaccess'));
             
    }


    private function createConfigSubdomainFile($subDomainName){
        $ssh = $this->connectSsh();
        print_r($ssh->exec('echo "
            
            {   
                "subdomain" : "'.$subDomainName.'"
            }
                    
             " >> /var/www/html/'.$subDomainName.'/application/config/subdomain.json')); 
    }
   


    private function createTables($serverName,$userName,$password,$subDomainName){
        try {
            $conn = new PDO("mysql:host=$serverName", $userName, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $dbName = "sbr_{$subDomainName}";
          

            $sql = ("    
            SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
            SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';
            
            -- -----------------------------------------------------
            -- Schema {$dbName}
            -- -----------------------------------------------------
            
            -- -----------------------------------------------------
            -- Schema {$dbName}
            -- -----------------------------------------------------
            CREATE SCHEMA IF NOT EXISTS `{$dbName}` DEFAULT CHARACTER SET utf8 ;
            USE `{$dbName}` ;
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`myrole`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`myrole` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(45) NOT NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`myuser`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`myuser` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(250) NOT NULL,
              `email` VARCHAR(250) NOT NULL,
              `password` VARCHAR(350) NOT NULL,
              `avatar` VARCHAR(150) NOT NULL,
              `last_login` VARCHAR(45) NULL,
              `last_activity` VARCHAR(45) NULL,
              `status` VARCHAR(5) NULL,
              `description` VARCHAR(600) NULL,
              `mode` VARCHAR(45) NOT NULL,
              `myrole_id` INT NOT NULL,
              `excluded` VARCHAR(5) NULL,
              `creation_date` DATE NULL,
              `lead` VARCHAR(45) NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_myuser_myrole_idx` (`myrole_id` ASC),
              CONSTRAINT `fk_myuser_myrole`
                FOREIGN KEY (`myrole_id`)
                REFERENCES `{$dbName}`.`myrole` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`social_networks`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`social_networks` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(250) NOT NULL,
              `url` VARCHAR(150) NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`myuser_has_social_networks`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`myuser_has_social_networks` (
              `myuser_id` INT NOT NULL,
              `social_networks_id` INT NOT NULL,
              `url` VARCHAR(250) NOT NULL,
              PRIMARY KEY (`myuser_id`, `social_networks_id`),
              INDEX `fk_myuser_has_social_networks_social_networks1_idx` (`social_networks_id` ASC),
              INDEX `fk_myuser_has_social_networks_myuser1_idx` (`myuser_id` ASC),
              CONSTRAINT `fk_myuser_has_social_networks_myuser1`
                FOREIGN KEY (`myuser_id`)
                REFERENCES `{$dbName}`.`myuser` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_myuser_has_social_networks_social_networks1`
                FOREIGN KEY (`social_networks_id`)
                REFERENCES `{$dbName}`.`social_networks` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`myuser_has_certificate`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`myuser_has_certificate` (
              `number` INT NOT NULL AUTO_INCREMENT,
              `myuser_id` INT NOT NULL,
              `course` VARCHAR(600) NULL,
              `date` DATE NULL,
              `certificate` VARCHAR(45) NULL,
              `mycourse_id` VARCHAR(45) NULL,
              INDEX `fk_myuser_has_certificate_myuser1_idx` (`myuser_id` ASC),
              PRIMARY KEY (`number`),
              CONSTRAINT `fk_myuser_has_certificate_myuser1`
                FOREIGN KEY (`myuser_id`)
                REFERENCES `{$dbName}`.`myuser` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`settings`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`settings` (
              `name` VARCHAR(250) NULL,
              `description` VARCHAR(250) NULL,
              `favicon` VARCHAR(250) NULL,
              `logo` VARCHAR(250) NULL,
              `email` VARCHAR(100) NULL,
              `phone` VARCHAR(100) NULL,
              `currency` VARCHAR(45) NULL,
              `marketplace` VARCHAR(5) NULL,
              `lang` VARCHAR(5) NOT NULL,
              `theme` VARCHAR(15) NOT NULL,
              `zone` VARCHAR(150) NOT NULL)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`mycompany`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`mycompany` (
              `name` VARCHAR(250) NOT NULL,
              `country` VARCHAR(45) NOT NULL,
              `plan` VARCHAR(45) NOT NULL,
              `contact` VARCHAR(150) NOT NULL,
              `email` VARCHAR(150) NOT NULL,
              `creation_date` DATE NOT NULL,
              `type_project` VARCHAR(500) NOT NULL,
              `step_project` VARCHAR(500) NOT NULL,
              `subdomain` VARCHAR(500) NOT NULL,
              `expiration` DATE NOT NULL)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`mygroup`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`mygroup` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(250) NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`mycategory`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`mycategory` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(250) NOT NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`ci_sessions`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`ci_sessions` (
              `id` VARCHAR(40) NOT NULL,
              `ip_address` VARCHAR(45) NOT NULL,
              `timestamp` INT(10) UNSIGNED NOT NULL DEFAULT 0,
              `data` BLOB NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `timestamp_UNIQUE` (`timestamp` ASC))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`mycourse`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`mycourse` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `title` VARCHAR(250) NOT NULL,
              `description` VARCHAR(800) NULL,
              `photo` VARCHAR(150) NULL,
              `price` VARCHAR(45) NULL,
              `creation_date` DATE NULL,
              `release_date` DATE NULL,
              `expiration_date` DATE NULL,
              `spotlight` VARCHAR(5) NULL,
              `validity` INT NULL,
              `preview` VARCHAR(45) NULL,
              `certificate` VARCHAR(45) NULL,
              `comments` VARCHAR(5) NULL,
              `creation_user` INT NOT NULL,
              `mycategory_id` INT NOT NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`mymodule`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`mymodule` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `title` VARCHAR(250) NOT NULL,
              `position` INT NULL,
              `required_to_next` VARCHAR(5) NULL,
              `release_date` DATE NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`type_mylesson`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`type_mylesson` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(100) NOT NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`mylesson`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`mylesson` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `title` VARCHAR(250) NOT NULL,
              `position` INT NULL,
              `path` VARCHAR(150) NULL,
              `ext` VARCHAR(45) NULL,
              `real_name` VARCHAR(250) NULL,
              `date` DATE NULL,
              `time` VARCHAR(45) NULL,
              `description` VARCHAR(600) NULL,
              `url` VARCHAR(250) NULL,
              `approval` INT NULL,
              `retest` INT NULL,
              `type_mylesson_id` INT NOT NULL,
              `status` VARCHAR(45) NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_mylesson_type_mylesson1_idx` (`type_mylesson_id` ASC),
              CONSTRAINT `fk_mylesson_type_mylesson1`
                FOREIGN KEY (`type_mylesson_id`)
                REFERENCES `{$dbName}`.`type_mylesson` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`type_question`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`type_question` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(150) NOT NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`question`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`question` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `weight` INT NULL,
              `question` VARCHAR(600) NULL,
              `image` VARCHAR(150) NULL,
              `position` INT NULL,
              `feedback` VARCHAR(600) NULL,
              `status` VARCHAR(45) NULL,
              `type_question_id` INT NOT NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_question_type_question1_idx` (`type_question_id` ASC),
              CONSTRAINT `fk_question_type_question1`
                FOREIGN KEY (`type_question_id`)
                REFERENCES `{$dbName}`.`type_question` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`answer`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`answer` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `answer` VARCHAR(600) NOT NULL,
              `correct` VARCHAR(15) NULL,
              `position` INT NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`program`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`program` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `title` VARCHAR(250) NOT NULL,
              `description` VARCHAR(600) NULL,
              `photo` VARCHAR(100) NULL,
              `release_date` DATE NULL,
              `expiration_date` DATE NULL,
              `creation_date` DATE NOT NULL,
              `creation_user` INT NOT NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`relationship`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`relationship` (
              `myuser_id` INT NOT NULL,
              `mycourse_id` INT NOT NULL,
              `mymodule_id` INT NOT NULL,
              `mylesson_id` INT NOT NULL,
              `mygroup_id` INT NOT NULL,
              `question_id` INT NOT NULL,
              `answer_id` INT NOT NULL,
              `program_id` INT NOT NULL,
              INDEX `fk_relationship_myuser1_idx` (`myuser_id` ASC),
              INDEX `fk_relationship_mycourse1_idx` (`mycourse_id` ASC),
              INDEX `fk_relationship_mymodule1_idx` (`mymodule_id` ASC),
              INDEX `fk_relationship_mylesson1_idx` (`mylesson_id` ASC),
              INDEX `fk_relationship_mygroup1_idx` (`mygroup_id` ASC),
              INDEX `fk_relationship_questions1_idx` (`question_id` ASC),
              INDEX `fk_relationship_answer1_idx` (`answer_id` ASC),
              CONSTRAINT `fk_relationship_myuser1`
                FOREIGN KEY (`myuser_id`)
                REFERENCES `{$dbName}`.`myuser` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_relationship_mycourse1`
                FOREIGN KEY (`mycourse_id`)
                REFERENCES `{$dbName}`.`mycourse` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_relationship_mymodule1`
                FOREIGN KEY (`mymodule_id`)
                REFERENCES `{$dbName}`.`mymodule` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_relationship_mylesson1`
                FOREIGN KEY (`mylesson_id`)
                REFERENCES `{$dbName}`.`mylesson` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_relationship_mygroup1`
                FOREIGN KEY (`mygroup_id`)
                REFERENCES `{$dbName}`.`mygroup` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_relationship_questions1`
                FOREIGN KEY (`question_id`)
                REFERENCES `{$dbName}`.`question` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_relationship_answer1`
                FOREIGN KEY (`answer_id`)
                REFERENCES `{$dbName}`.`answer` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_relationship_program1`
                FOREIGN KEY (`program_id`)
                REFERENCES `{$dbName}`.`program` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`header`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`header` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `logo` VARCHAR(150) NULL,
              `logo_size` INT NULL,
              `color` VARCHAR(45) NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`links`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`links` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `title` VARCHAR(150) NOT NULL,
              `url` VARCHAR(350) NOT NULL,
              `position` INT NOT NULL,
              `target` VARCHAR(45) NOT NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`header_has_links`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`header_has_links` (
              `header_id` INT NOT NULL,
              `links_id` INT NOT NULL,
              PRIMARY KEY (`header_id`, `links_id`),
              INDEX `fk_header_has_links_links1_idx` (`links_id` ASC),
              INDEX `fk_header_has_links_header1_idx` (`header_id` ASC),
              CONSTRAINT `fk_header_has_links_header1`
                FOREIGN KEY (`header_id`)
                REFERENCES `{$dbName}`.`header` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_header_has_links_links1`
                FOREIGN KEY (`links_id`)
                REFERENCES `{$dbName}`.`links` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`footer`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`footer` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `copyright` VARCHAR(350) NULL,
              `color` VARCHAR(45) NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`button`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`button` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `title` VARCHAR(150) NULL DEFAULT 'null',
              `url` VARCHAR(350) NULL,
              `target` VARCHAR(45) NULL,
              `color` VARCHAR(45) NULL,
              `color_hover` VARCHAR(45) NULL,
              `style` VARCHAR(45) NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`banner`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`banner` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `image` VARCHAR(350) NULL,
              `button_id` INT NOT NULL DEFAULT 1,
              `header` VARCHAR(300) NULL DEFAULT 'null',
              `subheader` VARCHAR(600) NULL DEFAULT 'null',
              `header_color` VARCHAR(45) NULL,
              `subheader_color` VARCHAR(45) NULL,
              `text_position` VARCHAR(45) NULL,
              `header_font` VARCHAR(45) NULL,
              `subheader_font` VARCHAR(45) NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_banner_cta1_idx` (`button_id` ASC),
              CONSTRAINT `fk_banner_cta1`
                FOREIGN KEY (`button_id`)
                REFERENCES `{$dbName}`.`button` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`product_list`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`product_list` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `number_of_products` INT NULL,
              `header` VARCHAR(150) NULL,
              `subheader` VARCHAR(600) NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`testimonial`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`testimonial` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `header` VARCHAR(300) NULL,
              `subheader` VARCHAR(600) NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`text_and_media`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`text_and_media` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `header` VARCHAR(250) NULL,
              `content` VARCHAR(1000) NULL,
              `media` VARCHAR(150) NULL,
              `media_position` VARCHAR(45) NULL,
              `button_id` INT NOT NULL DEFAULT 1,
              `button_align` VARCHAR(15) NULL,
              `subheader` VARCHAR(600) NULL,
              `media_align` VARCHAR(45) NULL,
              `text_align` VARCHAR(45) NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_text_and_media_cta1_idx` (`button_id` ASC),
              CONSTRAINT `fk_text_and_media_cta1`
                FOREIGN KEY (`button_id`)
                REFERENCES `{$dbName}`.`button` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`section`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`section` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `position` INT NOT NULL,
              `banner_id` INT NOT NULL DEFAULT 1,
              `product_list_id` INT NOT NULL DEFAULT 1,
              `testimonial_id` INT NOT NULL DEFAULT 1,
              `text_and_media_id` INT NOT NULL DEFAULT 1,
              `type` VARCHAR(150) NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_section_banner1_idx` (`banner_id` ASC),
              INDEX `fk_section_product_list1_idx` (`product_list_id` ASC),
              INDEX `fk_section_testimonial1_idx` (`testimonial_id` ASC),
              INDEX `fk_section_text_and_media1_idx` (`text_and_media_id` ASC),
              CONSTRAINT `fk_section_banner1`
                FOREIGN KEY (`banner_id`)
                REFERENCES `{$dbName}`.`banner` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_section_product_list1`
                FOREIGN KEY (`product_list_id`)
                REFERENCES `{$dbName}`.`product_list` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_section_testimonial1`
                FOREIGN KEY (`testimonial_id`)
                REFERENCES `{$dbName}`.`testimonial` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_section_text_and_media1`
                FOREIGN KEY (`text_and_media_id`)
                REFERENCES `{$dbName}`.`text_and_media` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`persons`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`persons` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `name` VARCHAR(150) NOT NULL,
              `occupation` VARCHAR(150) NULL,
              `comment` VARCHAR(150) NULL,
              `photo` VARCHAR(150) NULL,
              `position` INT NULL,
              PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`testimonial_has_persons`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`testimonial_has_persons` (
              `testimonial_id` INT NOT NULL,
              `persons_id` INT NOT NULL,
              PRIMARY KEY (`testimonial_id`, `persons_id`),
              INDEX `fk_testimonial_has_persons_persons1_idx` (`persons_id` ASC),
              INDEX `fk_testimonial_has_persons_testimonial1_idx` (`testimonial_id` ASC),
              CONSTRAINT `fk_testimonial_has_persons_testimonial1`
                FOREIGN KEY (`testimonial_id`)
                REFERENCES `{$dbName}`.`testimonial` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_testimonial_has_persons_persons1`
                FOREIGN KEY (`persons_id`)
                REFERENCES `{$dbName}`.`persons` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`footer_has_social_networks`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`footer_has_social_networks` (
              `footer_id` INT NOT NULL,
              `social_networks_id` INT NOT NULL,
              PRIMARY KEY (`footer_id`, `social_networks_id`),
              INDEX `fk_footer_has_social_networks_social_networks1_idx` (`social_networks_id` ASC),
              INDEX `fk_footer_has_social_networks_footer1_idx` (`footer_id` ASC),
              CONSTRAINT `fk_footer_has_social_networks_footer1`
                FOREIGN KEY (`footer_id`)
                REFERENCES `{$dbName}`.`footer` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_footer_has_social_networks_social_networks1`
                FOREIGN KEY (`social_networks_id`)
                REFERENCES `{$dbName}`.`social_networks` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`lesson_status`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`lesson_status` (
              `status` VARCHAR(50) NULL,
              `myuser_id` INT NOT NULL,
              `mylesson_id` INT NOT NULL,
              `mycourse_id` INT NOT NULL,
              `score` INT NULL,
              `retest` INT NULL DEFAULT 0,
              INDEX `fk_lesson_status_mylesson1_idx` (`mylesson_id` ASC),
              CONSTRAINT `fk_lesson_status_myuser1`
                FOREIGN KEY (`myuser_id`)
                REFERENCES `{$dbName}`.`myuser` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_lesson_status_mylesson1`
                FOREIGN KEY (`mylesson_id`)
                REFERENCES `{$dbName}`.`mylesson` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_lesson_status_mycourse1`
                FOREIGN KEY (`mycourse_id`)
                REFERENCES `{$dbName}`.`mycourse` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`users_answers`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`users_answers` (
              `myuser_id` INT NOT NULL,
              `question_id` INT NOT NULL,
              `answer` VARCHAR(600) NULL,
              `score` INT NULL,
              `feedback` VARCHAR(600) NULL,
              `feedback_useful` VARCHAR(45) NULL,
              `feedback_user` INT NULL,
              INDEX `fk_users_answers_question1_idx` (`question_id` ASC),
              CONSTRAINT `fk_users_answers_myuser1`
                FOREIGN KEY (`myuser_id`)
                REFERENCES `{$dbName}`.`myuser` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_users_answers_question1`
                FOREIGN KEY (`question_id`)
                REFERENCES `{$dbName}`.`question` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`integrations`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`integrations` (
              `mp_public_key` VARCHAR(150) NULL,
              `mp_access_token` VARCHAR(150) NULL,
              `mp_country` VARCHAR(45) NULL,
              `mp_last_update` DATE NULL,
              `ga_id` VARCHAR(150) NULL,
              `fb_id` VARCHAR(150) NULL,
              `gtm_id` VARCHAR(150) NULL,
              `preference_id` VARCHAR(600) NULL)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`program_has_mycourse`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`program_has_mycourse` (
              `program_id` INT NOT NULL,
              `mycourse_id` INT NOT NULL,
              `position` INT NULL,
              PRIMARY KEY (`program_id`, `mycourse_id`),
              INDEX `fk_program_has_mycourse_mycourse1_idx` (`mycourse_id` ASC),
              INDEX `fk_program_has_mycourse_program1_idx` (`program_id` ASC),
              CONSTRAINT `fk_program_has_mycourse_program1`
                FOREIGN KEY (`program_id`)
                REFERENCES `{$dbName}`.`program` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_program_has_mycourse_mycourse1`
                FOREIGN KEY (`mycourse_id`)
                REFERENCES `{$dbName}`.`mycourse` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`payments`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`payments` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `payment_id` VARCHAR(600) NULL,
              `payment_status` VARCHAR(45) NULL,
              `myuser_id` INT NOT NULL,
              `mycourse_id` INT NOT NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_payments_myuser1_idx` (`myuser_id` ASC),
              INDEX `fk_payments_mycourse1_idx` (`mycourse_id` ASC),
              CONSTRAINT `fk_payments_myuser1`
                FOREIGN KEY (`myuser_id`)
                REFERENCES `{$dbName}`.`myuser` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_payments_mycourse1`
                FOREIGN KEY (`mycourse_id`)
                REFERENCES `{$dbName}`.`mycourse` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`activities`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`activities` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `create_user` INT NOT NULL,
              `mylesson_id` INT NOT NULL,
              `mycourse_id` INT NOT NULL,
              `program_id` INT NOT NULL,
              `type` VARCHAR(45) NULL,
              `lead_name` VARCHAR(45) NULL,
              `date` DATETIME NULL,
              `course_title` VARCHAR(150) NULL,
              `lesson_title` VARCHAR(150) NULL,
              `module_title` VARCHAR(150) NULL,
              `program_title` VARCHAR(45) NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_activities_myuser1_idx` (`create_user` ASC),
              INDEX `fk_activities_mylesson1_idx` (`mylesson_id` ASC),
              INDEX `fk_activities_mycourse1_idx` (`mycourse_id` ASC),
              INDEX `fk_activities_program1_idx` (`program_id` ASC),
              CONSTRAINT `fk_activities_myuser1`
                FOREIGN KEY (`create_user`)
                REFERENCES `{$dbName}`.`myuser` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_activities_mylesson1`
                FOREIGN KEY (`mylesson_id`)
                REFERENCES `{$dbName}`.`mylesson` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_activities_mycourse1`
                FOREIGN KEY (`mycourse_id`)
                REFERENCES `{$dbName}`.`mycourse` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_activities_program1`
                FOREIGN KEY (`program_id`)
                REFERENCES `{$dbName}`.`program` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;
            
            
            -- -----------------------------------------------------
            -- Table `{$dbName}`.`course_helper`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`course_helper` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `myuser_id` INT NOT NULL,
              `mycourse_id` INT NOT NULL,
              `end_date` DATE NULL,
              `enroll_date` DATE NULL,
              `status` VARCHAR(45) NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_course_helper_myuser1_idx` (`myuser_id` ASC),
              INDEX `fk_course_helper_mycourse1_idx` (`mycourse_id` ASC),
              CONSTRAINT `fk_course_helper_myuser1`
                FOREIGN KEY (`myuser_id`)
                REFERENCES `{$dbName}`.`myuser` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_course_helper_mycourse1`
                FOREIGN KEY (`mycourse_id`)
                REFERENCES `{$dbName}`.`mycourse` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION)
            ENGINE = InnoDB;

            -- -----------------------------------------------------
            -- Table `{$dbName}`.`tokens`
            -- -----------------------------------------------------
            CREATE TABLE IF NOT EXISTS `{$dbName}`.`tokens` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `token` VARCHAR(600) NOT NULL,
            `expiration` DATETIME NULL,
            PRIMARY KEY (`id`))
            ENGINE = InnoDB;
            
            
            SET SQL_MODE=@OLD_SQL_MODE;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
            SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
            
            ");
            $conn->exec($sql);
        }
        catch(Exception $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
        }
    }

    private function insertIntoDataBase($serverNameRds,$userNameRds,$passwordRds,$subDomainName,$userEmail,$userName,$userPassword,$userPhone,$step,$goal,$token){
        $dbName = "sbr_{$subDomainName}";
        try {
            $conn = new PDO("mysql:host=$serverNameRds;dbname=$dbName", $userNameRds, $passwordRds);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        catch(Exception $e) {
            echo 'Exception -> ';
            var_dump($e->getMessage());
        }

       

        /*  Insert into settings */
        $rowsToInsert = array(
            array(
                'name' => 'Sabiorealm',
                'description' => 'Disruptive education',
                'favicon' => 'favicon.png',
                'logo' => 'sabiorealm.png',
                'email' => 'youremail@company.com',
                'phone' => '+55 41 99713-8892',
                'marketplace' => 'on',
                'lang' => 'en',
                'theme' => 'default',
                'zone' => 'America/Bogota'
            )
        );
        $this->pdoMultiInsert('settings', $rowsToInsert, $conn);

        /* Insert into mycompany */
        $rowsToInsert = array(
            array(
                'name' => $subDomainName,
                'country' => $this->getUserCountry(),
                'plan' => 'trial',
                'contact' => $userPhone,
                'email' => $userEmail,
                'creation_date' => date("Y-m-d"),
                'type_project' =>  $goal,
                'step_project' => $step,
                'subdomain' => $subDomainName,
                'expiration' =>  date("Y-m-d", strtotime("+7 days")),
            )
        );
        $this->pdoMultiInsert('mycompany', $rowsToInsert, $conn);

        /* Insert into myrole */
        $rowsToInsert = array(
            array(
                'name' => 'administrator',
            ),
            array(
                'name' => 'instructor',
            ),
            array(
                'name' => 'student',
            )
        );
        $this->pdoMultiInsert('myrole', $rowsToInsert, $conn);

        /* Insert into myuser */
        $rowsToInsert = array(
            array(
                'name' => $userName,
                'email' => $userEmail,
                'password' => md5($userPassword),
                'avatar' => 'default.png',
                'status' => 'on',
                'description' => 'User description',
                'mode' => 'enable',
                'myrole_id' =>  1
            )
        );
        $this->pdoMultiInsert('myuser', $rowsToInsert, $conn);

        /* Insert into mycategory */
        $rowsToInsert = array(
            array(
                'name' => 'default',
            )
        );
        $this->pdoMultiInsert('mycategory', $rowsToInsert, $conn);

        /* Insert into mygroup */
        $rowsToInsert = array(
            array(
                'name' => 'default',
            )
        );
        $this->pdoMultiInsert('mygroup', $rowsToInsert, $conn);

        /* Insert into program */
        $rowsToInsert = array(
            array(
                'title' => 'default',
                'creation_date' => date("Y-m-d"),
                'creation_user' => 1
            )
        );
        $this->pdoMultiInsert('program', $rowsToInsert, $conn);
        
        /* Insert into type_mylesson */
        $rowsToInsert = array(
            array(
                'name' => 'video',
            ),
            array(
                'name' => 'audio',
            ),
            array(
                'name' => 'pdf',
            ),
            array(
                'name' => 'downloadable',
            ),
            array(
                'name' => 'videocall',
            ),
            array(
                'name' => 'webinar',
            ),
            array(
                'name' => 'html',
            ),
            array(
                'name' => 'exam',
            )
        );
        $this->pdoMultiInsert('type_mylesson', $rowsToInsert, $conn);

        /* Insert into type_question */
        $rowsToInsert = array(
            array(
                'name' => 'descriptive',
            ),
            array(
                'name' => 'multiple',
            ),
            array(
                'name' => 'free',
            ),
        );
        $this->pdoMultiInsert('type_question', $rowsToInsert, $conn);

        /* Insert into question */
        $rowsToInsert = array(
            array(
                'question' => 'descriptive',
                'type_question_id' => 1
            ),
        );
        $this->pdoMultiInsert('question', $rowsToInsert, $conn);

        /* Insert into answer */
        $rowsToInsert = array(
            array(
                'answer' => 'default',
            ),
        );
        $this->pdoMultiInsert('answer', $rowsToInsert, $conn);

        /* Insert into mylesson */
        $rowsToInsert = array(
            array(
                'title' => 'default',
                'type_mylesson_id' => 1
            ),
        );
        $this->pdoMultiInsert('mylesson', $rowsToInsert, $conn);

        /* Insert into mymodule */
        $rowsToInsert = array(
            array(
                'title' => 'default',
            ),
        );
        $this->pdoMultiInsert('mymodule', $rowsToInsert, $conn);

        /* Insert into mycourse */
        $rowsToInsert = array(
            array(
                'title' => 'default',
                'creation_user' => 1,
                'mycategory_id' => 1
            ),
        );
        $this->pdoMultiInsert('mycourse', $rowsToInsert, $conn);

        /* Insert into header */
        $rowsToInsert = array(
            array(
                'logo' => 'sabiorealm.png',
                'logo_size' => '15',
                'color' => '#1E90FF'
            ),
        );
        $this->pdoMultiInsert('header', $rowsToInsert, $conn);

        /* Insert into integrations */
        $rowsToInsert = array(
            array(
                'mp_public_key' => 'default',
                'mp_access_token' => 'default',
                'mp_country' => 'default',
                'mp_last_update' => '0000-00-00',
                'ga_id' => 'default',
                'preference_id' => 'default'
            ),
        );
        $this->pdoMultiInsert('integrations', $rowsToInsert, $conn);

        /* Insert into button */
        $rowsToInsert = array(
            array(
                'title' => 'default',
                'color' => 'default',
                'color_hover' => 'default',
                'style' => 'default',
            ),
            array(
                'title' => 'SEE ALL COURSES',
                'color' => '#4682B4',
                'color_hover' => '#4285f4',
                'style' => 'plain',
            )
        );
        $this->pdoMultiInsert('button', $rowsToInsert, $conn);

        /* Insert into text_and_media */
        $rowsToInsert = array(
            array(
                'button_id' => 1,
            ),
        );
        $this->pdoMultiInsert('text_and_media', $rowsToInsert, $conn);

        /* Insert into testimonial */
        $rowsToInsert = array(
            array(
                'header' => 'default',
                'subheader' => 'default'
            ),
        );
        $this->pdoMultiInsert('testimonial', $rowsToInsert, $conn);

        /* Insert into product_list */
        $rowsToInsert = array(
            array(
                'number_of_products' => 10,
            ),
        );
        $this->pdoMultiInsert('product_list', $rowsToInsert, $conn);

        /* Insert into banner */
        $rowsToInsert = array(
            array(
                'image' => 'default_banner.png',
                'button_id' => 1,
                'header' => 'default',
                'subheader' => 'default',
                'header_color' => '#fff',
                'subheader_color' => '#fff',
                'text_position' => 'center'
            ),
            array(
                'image' => 'default_banner.png',
                'button_id' => 2,
                'header' => 'Design digital',
                'subheader' => 'Improve your skills and become the best in digital design.',
                'header_color' => '#fff',
                'subheader_color' => '#fff',
                'text_position' => 'center'
            )
        );
        $this->pdoMultiInsert('banner', $rowsToInsert, $conn);

        /* Insert into section */
        $rowsToInsert = array(
            array(
                'position' => 0,
                'banner_id' => 2,
                'product_list_id' => 1,
                'testimonial_id' => 1,
                'text_and_media_id' => 1,
                'type' => 'banner'
            ),
        );
        $this->pdoMultiInsert('section', $rowsToInsert, $conn);

        /* Insert into footer */
        $rowsToInsert = array(
            array(
                'copyright' => 'Sabiorealm',
                'color' => '#1A2EC4',
            ),
        );
        $this->pdoMultiInsert('footer', $rowsToInsert, $conn);
    }


    private function pdoMultiInsert($tableName, $data, $pdoObject){
    
        //Will contain SQL snippets.
        $rowsSQL = array();
    
        //Will contain the values that we need to bind.
        $toBind = array();
        
        //Get a list of column names to use in the SQL statement.
        $columnNames = array_keys($data[0]);
    
        //Loop through our $data array.
        foreach($data as $arrayIndex => $row){
            $params = array();
            foreach($row as $columnName => $columnValue){
                $param = ":" . $columnName . $arrayIndex;
                $params[] = $param;
                $toBind[$param] = $columnValue; 
            }
            $rowsSQL[] = "(" . implode(", ", $params) . ")";
        }
    
        //Construct our SQL statement
        $sql = "INSERT INTO `$tableName` (" . implode(", ", $columnNames) . ") VALUES " . implode(", ", $rowsSQL);
    
        //Prepare our PDO statement.
        $pdoStatement = $pdoObject->prepare($sql);
    
        //Bind our values.
        foreach($toBind as $param => $val){
            $pdoStatement->bindValue($param, $val);
        }
        
        //Execute our statement (i.e. insert the data).
        return $pdoStatement->execute();
    } 

    private function getUserCountry(){
        $vis_ip = $this->getVisIpAddr();
           
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $vis_ip));  
         
        if($ipdat->geoplugin_countryName){
            $country = $ipdat->geoplugin_countryName;
        } else{
            $country = "NA";
        }

        return $country;
    }

    private function getVisIpAddr(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
            return $_SERVER['HTTP_CLIENT_IP']; 
        } 
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
            return $_SERVER['HTTP_X_FORWARDED_FOR']; 
        } 
        else { 
            return $_SERVER['REMOTE_ADDR']; 
        } 
    }
}
