<?php

namespace App\Helpers;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
    // টোকেন তৈরি করার ফাংশন
    public static function CreateToken($userEmail,$userID): string
    {
        $key = env('JWT_KEY'); // .env ফাইল থেকে গোপন কী নেওয়া
        $payload = [
            'iss' => 'laravel-token', // টোকেন ইস্যুকারী
            'iat' => time(), // টোকেন তৈরি করার সময়
            'exp' => time() + 60 * 60, // এক ঘণ্টা পর টোকেনের মেয়াদ শেষ হবে
            'userEmail' => $userEmail, // ব্যবহারকারীর ইমেইল
            'userID'=>$userID
        ];

        // JWT ক্লাস ব্যবহার করে পে-লোড এনকোড করা
        return JWT::encode($payload, $key, 'HS256');
    }
    public static function CreateTokenForSetPassword($userEmail): string
    {
        $key = env('JWT_KEY'); // .env ফাইল থেকে গোপন কী নেওয়া
        $payload = [
            'iss' => 'laravel-token', // টোকেন ইস্যুকারী
            'iat' => time(), // টোকেন তৈরি করার সময়
            'exp' => time() + 60 * 20, // এক ঘণ্টা পর টোকেনের মেয়াদ শেষ হবে
            'userEmail' => $userEmail, // ব্যবহারকারীর ইমেইল
            'userID'=>'0'
        ];

        // JWT ক্লাস ব্যবহার করে পে-লোড এনকোড করা
        return JWT::encode($payload, $key, 'HS256');
    }

    // টোকেন যাচাই করার ফাংশন
    public static function VerifyToken($token): string|object // ফাংশনের জন্য শুরু
    {
        try { // try ব্লকের জন্য শুরু
            if ($token == null) { // if ব্লকের জন্য শুরু
                return "unauthorized"; 
            } else { // else ব্লকের জন্য শুরু
                $key = env('JWT_KEY'); 
                $decoded = JWT::decode($token, new Key($key, 'HS256')); 
                return $decoded; 
            } // else ব্লকের শেষ
        } catch (Exception $e) { // catch ব্লকের জন্য শুরু
            return 'unauthorized';
        } // catch ব্লকের শেষ
    } // ফাংশনের শেষ
    
}
