<?php
namespace App\Traits;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Exception\FirebaseException;

trait Firebase
{
  protected function firestore($file, $filename)
  {

    try {
      $storage = app('firebase.storage');
      $storageClient = $storage->getStorageClient();
      $defaultBucket = $storage->getBucket();

      $object = $defaultBucket->upload(
        $file,
        [
          'predefinedAcl' => 'publicRead',
          'name' => $filename,
        ]
      );

      $url = 'https://storage.googleapis.com/' . $object->info()['bucket'] . '/' . $object->info()['name'];
      return $url;

    } catch (FirebaseException $e) {
      return $e;
    }
  }

  protected function send_to_device($title, $content, $fcm_token)
  {
    try {
      $messaging = app('firebase.messaging');

      $notification = \Kreait\Firebase\Messaging\Notification::fromArray([
        'title' => $title,
        'body' => $content,
        //'image' => $imageUrl,
      ]);

      if ($fcm_token) {

        $message = CloudMessage::withTarget('token', $fcm_token)
          ->withNotification($notification) // optional
          //->withData($data) // optional
        ;

        $messaging->send($message);
      }

      return;
    } catch (FirebaseException $e) {
      return $e;
    }


  }
  protected function send_to_devices($title, $content, $fcm_tokens)
  {
    try {
      $messaging = app('firebase.messaging');

      $notification = \Kreait\Firebase\Messaging\Notification::fromArray([
        'title' => $title,
        'body' => $content,
        //'image' => $imageUrl,
      ]);

      $message = CloudMessage::new()
        ->withNotification($notification) // optional
        //->withData($data) // optional
      ;

      $messaging->sendMulticast($message, $fcm_tokens);

      return;
    } catch (FirebaseException $e) {
      return $e;
    }

  }

  protected function get_realtime_data()
  {
    $factory = (new Factory)
      ->withServiceAccount(base_path(env('GOOGLE_APPLICATION_CREDENTIALS')))
      ->withDatabaseUri('https://gs-retour-default-rtdb.firebaseio.com');

    $database = $factory->createDatabase();
    $reference = $database->getReference('drivers');
    $snapshot = $reference->getSnapshot()->getValue();
    return $snapshot;
  }
}
