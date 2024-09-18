<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'third_party/aws-sdk-php/aws-autoloader.php'; // Path to autoload.php


use Aws\Ses\SesClient;
use Aws\Exception\AwsException;


class Aws_sdk
{

    public function triggerEmail($email, $subject, $message)
    {





        $credentials = [
            'version' => 'latest',
            'region' => '',
            'credentials' => [
                'key' => '',
                'secret' => ''
            ]
        ];

        // Create an SES client
        $client = new SesClient($credentials);

        // Specify the email parameters
        $sender = 'Noreply@mcehassan.ac.in';
        $recipient = $email;
        $subject = $subject;
        $htmlBody = $message;

        // Try to send the email
        try {
            $result = $client->sendEmail([
                'Destination' => [
                    'ToAddresses' => [$recipient],
                ],
                'Message' => [
                    'Body' => [
                        'Html' => [
                            'Charset' => 'UTF-8',
                            'Data' => $htmlBody,
                        ]
                    ],
                    'Subject' => [
                        'Charset' => 'UTF-8',
                        'Data' => $subject,
                    ],
                ],
                'Source' => $sender,
            ]);

            // Print a success message if the email was sent successfully
            echo "Email sent! Message ID: " . $result['MessageId'] . "\n";
        } catch (AwsException $e) {
            // Print an error message if sending the email fails
            echo "The email could not be sent. Error: " . $e->getAwsErrorMessage() . "\n";
        }
    }
}
