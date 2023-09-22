<?php
use Kreait\Firebase\Auth\InvalidToken;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use DateTimeZone; // Add this line

session_start();
include('dbcon.php');

if(isset($_POST['login_now_btn']))
{
    $email = $_POST['email'];
    $clearTextPassword = $_POST['password'];

    try {
        // $user = $auth->getUserByEmail("$email");

        // $signInResult = $auth->signInWithEmailAndPassword($email, $clearTextPassword);
        // $idTokenString = $signInResult->idToken();
        $user = $auth->signInWithEmailAndPassword($email, $clearTextPassword);


        try {
            // $verifiedIdToken = $auth->verifyIdToken($idTokenString);
            // $uid = $verifiedIdToken->claims()->get('sub');

            // $_SESSION['verified_user_id'] = $uid;
            // $_SESSION['idTokenString'] = $idTokenString;

            $_SESSION['status'] = "You are Logged in successfully";
            header(("Location: home.php"));
            exit();

        } catch (InvalidToken $e) {
            echo 'The token is invalid: '.$e->getMessage();
        } catch (\InvalidArgumentException $e){
            echo 'The token could not be parsed: '.$e->getMessage();
        }

    } catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn $e) {
        // echo $e->getMessage();
        $_SESSION['status'] = "No Email Found";
        header(("Location: login.php"));
        exit();
    }
}

?>