<?php
/**
 * AmazonSesMessage & AmazonSesService
 *
 * Copyright (c) 2013 Mytour Ltd,.
 *
 * Class gửi Email thông qua Amazon SES Provider [http://aws.amazon.com/ses/]
 *
 * @copyright  Copyright (c) 2013 Mytour Ltd,. (http://mytour.vn)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt LGPL
 * @version    1.0.0
 * @author ManhTran manhtt@vatgia.com
 */

class AmazonSesMessage {

   /**
    * Message sending info
    */
   private $from;
   private $to;
   private $subject;
   private $message;
   private $file_content = null;
   private $attachFileName = null;
   private $responseInfo = array();

   /**
    * Set source email
    * @param String $email Email addr
    */
   public function setFrom($email) {
      if ($this->validateEmail($email)) {
         $this->from = $email;
      } else {
         throw new Exception('Invalid email!');
      }
      return $this;
   }

   /**
    * Set destination email
    * @param string|array $value Email addr
    */
   public function setTo($email) {
      if ($this->validateEmail($email)) {
         $this->to = $email;
      } else {
         throw new Exception('Invalid email!');
      }
      return $this;
   }

   /**
    * Email subject
    * @param String $subject Email subject
    */
   public function setSubject($subject) {
      $this->subject = $subject;
      return $this;
   }

   /**
    * Email body content
    * @param string $message Body content
    */
   public function setMessage($message) {
      $this->message = $message;
      return $this;
   }

   /**
    * [setAttachFileName description]
    * @param [type] $filePath [description]
    */
   public function setAttachFileName($filePath) {
      $file_parts = explode('/', $filePath);
      $filename = array_pop($file_parts);
      $this->attachFileName = $filename;
      return $this;
   }

   /**
    * Get email addr source
    * @return email addr
    */
   public function getFrom() {
      return $this->from;
   }

   /**
    * Get email addr destination
    * @return email addr
    */
   public function getTo() {
      return $this->to;
   }

   /**
    * Get email subject
    * @return [type] [description]
    */
   public function getSubject() {
      return $this->subject;
   }

   /**
    * Get email body content
    * @return String body content
    */
   public function getMessage() {
      return $this->message;
   }

   /**
    * Attach file from url
    * @param  string $filePath Native file path
    * @return void
    */
   public function attachFile($filePath) {
      if ($this->validateAttachFile($filePath)) {
         $this->setAttachFileName($filePath);
         $buffer_file = file_get_contents($filePath);
         $this->file_content = base64_encode($buffer_file);
      } else {
         throw new Exception('Invalid file path!');
      }
   }

   /**
    * Get an attach file name
    * @return Attach file name
    */
   public function getAttachFileName() {
      return $this->attachFileName;
   }

   /**
    * Get content of attach file
    * @return base64_encode attach file name
    */
   public function getAttachFileContent() {
      return $this->file_content;
   }

   /**
    * Message builder with file attached
    * @return String Message content in base64_encode
    */
   public function buildMessageWithFileAttached() {

      $message = "To: " . $this->getTo() . "\n";
      $message.= "From: " . $this->getFrom() . "\n";
      $message.= "Subject: " . $this->getSubject() . "\n";
      $message.= "MIME-Version: 1.0\n";
      $message.= 'Content-Type: multipart/mixed; boundary="aRandomString_with_signs_or_9879497q8w7r8number"';
      $message.= "\n\n";
      $message.= "--aRandomString_with_signs_or_9879497q8w7r8number\n";
      $message.= 'Content-Type: text/html; charset="utf-8"';
      $message.= "\n";
      $message.= "Content-Transfer-Encoding: 7bit\n";
      $message.= "Content-Disposition: inline\n";
      $message.= "\n";
      $message.= $this->getMessage() . "\n";
      $message.= "\n\n";
      $message.= "--aRandomString_with_signs_or_9879497q8w7r8number\n";
      $message.= "Content-ID: \<77987_SOME_WEIRD_TOKEN_BUT_UNIQUE_SO_SOMETIMES_A_@domain.com_IS_ADDED\>\n";
      $message.= 'Content-Type: application/pdf; name="' . $this->getAttachFileName() . '"';
      $message.= "\n";
      $message.= "Content-Transfer-Encoding: base64\n";
      $message.= 'Content-Disposition: attachment; filename="' . $this->getAttachFileName() . '"'; // Input
      $message.= "\n";
      $message.= $this->getAttachFileContent();
      $message.= "\n";
      $message.= "--aRandomString_with_signs_or_9879497q8w7r8number--\n";

      return $message;
   }

   /**
    * Hàm parse thông tin từ 1 response sau khi gửi email
    * @param  object $response Amazon CFResponse Object
    * @return void
    */
   public function parseResponseObjectToArray($response) {
      $headerResponse = $response->header;
      $this->responseInfo = $headerResponse['_info'];
   }

   /**
    * Hàm lấy thông tin response sau khi gửi email
    * @return array Response info
    */
   public function getResponseInfo() {
      return $this->responseInfo;
   }

   /**
    * Validate email addr
    * @param  String|array $email Email address
    * @return boolean   true/false
    */
   public function validateEmail($email) {
      foreach ((array) $email as $e) {
         $e = strtolower(trim($e));
         if ( !filter_var($e, FILTER_VALIDATE_EMAIL))
            return false;
      }
      return true;
   }

   /**
    * Validate attach file
    * @param  string $value Path to attach file
    * @return boolean
    */
   public function validateAttachFile($filePath) {
      if (file_exists($filePath) && is_file($filePath) && is_readable($filePath)) {
         $maxFileSize = 3 * 1024 * 1024; // 3Mb
         if (filesize($filePath) < $maxFileSize) {
            return true;
         } else {
            throw new Exception('File sizes must less than 3Mb');
         }
      }
      return false;
   }

   /**
    * Send email
    * @param  Instance of Amazon Simple Email Service
    * @return Object Amazon response object
    */
   public function sendEmail($amazonSES) {

      // Message content builder
      if ($this->attachFileName != null) {

         $message = $this->buildMessageWithFileAttached();

         // Send message
         $response = $amazonSES->send_raw_email(array(
            'Data'=> base64_encode($message),
            array(
               'Source' => $this->getFrom(),
               'Destinations' => $this->getTo())
         ));
      } else {
         // $ses->send_email ($source, $destination, $message, $opt);
         $response = $amazonSES->send_email(
            $this->getFrom(),
            array(
               'ToAddresses' => (array) $this->getTo()),
            array(
               'Subject' => array(
                  'Data' => $this->getSubject(),
                  'Charset' => 'UTF-8'),
               'Body' => array(
                  'Html' => array(
                     'Data' => $this->getMessage(),
                     'Charset' => 'UTF-8'),
                  'Text' => array(
                     'Data' => strip_tags($this->getMessage()),
                     'Charset' => 'UTF-8'))
            )
         );
      }

      $this->parseResponseObjectToArray($response);

      return $response;
   }
}

/**
 * AmazonSesService
 * Các xử lý lấy thông tin thống kê từ amazon
 */
class AmazonSesService {

   /**
    * Instance of Amazon SES class
    * @var Object
    */
   private $amazonSES;

   /**
    * Khởi tạo thể hiện của class
    * @param object $amazonSES Instance of Amazon SES class.
    */
   public function __construct($amazonSES) {
      $this->amazonSES = $amazonSES;
   }

   /**
    * Lấy danh sách các email được thiết lập làm địa chỉ gửi.
    * @return [type] [description]
    */
   public function getEmailList() {
      $response = $this->amazonSES->list_verified_email_addresses();
      return (array) $response->body->ListVerifiedEmailAddressesResult->VerifiedEmailAddresses->member;
   }

   /**
    * Lấy thông tin thống kê lưu lượng sử dụng của tài khoản.
    * @return array Quota statistics.
    */
   public function getSendQuota() {
      $response = $this->amazonSES->get_send_quota();
      $data = $response->body->GetSendQuotaResult;
      $data->Remaining = $data->Max24HourSend - $data->SentLast24Hours;
      return (array) $data;
   }

   /**
    * Lấy thông tin thống kê lượng email gửi (Gửi thành công, thất bại...)
    * @return array Delivery statistics.
    */
   public function getSendStatistics() {
      $dataReturn = array();
      $response = $this->amazonSES->get_send_statistics();
      foreach ($response->body->GetSendStatisticsResult->SendDataPoints->member as $dataItem) {
         $dataReturn[] = (array) $dataItem;
      }

      return $dataReturn;
   }
}