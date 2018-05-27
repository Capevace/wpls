<?php

namespace App\Service;

// use App\Log;
// use App\LicenseActivation;

/**
 * The class that handles activating and deactivating of licenses.
 */
// class PackageLog
// {
//     public const DEFAULT = 'default';
//     public const METADATA = 'metadata';
//     public const ACTIVATION = 'activation';
//     public const DEACTIVATION = 'deactivation';
//     public const LEGACY_VERIFICATION = 'legacy_verification';

//     /**
//      * Write a package log with a message and a context.
//      *
//      * @param string $type The log type.
//      * @param string $message The log message.
//      * @param array $context The context data.
//      */
//     public function log(string $type, string $message, array $context = [])
//     {
        
//     }

//     /**
//      * Write a default package log with a message and a context.
//      *
//      * @param string $message The log message.
//      * @param array $context The context data.
//      */
//     public function default(string $message, array $context = [])
//     {
//         $this->log(static::DEFAULT, $message, $context);
//     }

//     /**
//      * Write a default package log with a message and a context.
//      *
//      * @param array $context The context data.
//      */
//     public function metadata(Site $site, array $context = [])
//     {
//         $this->log(static::METADATA, 'Fetched metadata.', array_merge([
//             'site' => $site
//         ], $context));
//     }

//     /**
//      * Write an activation package log with a message and a context.
//      *
//      * @param null|App\LicenseActivation $activation The activation that was issued.
//      * @param array $context The context data.
//      */
//     public function activation(LicenseActivation $activation = null, array $context = [])
//     {
//         $this->log(static::ACTIVATION, 'Activated license.', array_merge([
//             'activation' => $activation,
//             'site' => $activation->site
//         ], $context));
//     }

//     /**
//      * Write a deactivation package log with a message and a context.
//      *
//      * @param array $context The context data.
//      */
//     public function deactivation(License $license, Site $site, array $context = [])
//     {
//         $this->log(static::DEACTIVATION, 'Deactivated license.', $context);
//     }
// }