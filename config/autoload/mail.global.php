<?php
return array(

    'mail_options' => array(

        /***********
         * ADAPTER *
         ***********/

        /*
         * The mail adapter to be used.
         * You can define any class implementing Zend\Mail\Transport\TransportInterface,
         * either the class fully qualified name or the instance to be used.
         * For standard mail transports, you can use aliases,
         *      - sendmail  => Zend\Mail\Transport\Sendmail
         *      - smtp      => Zend\Mail\Transport\Smtp
         *      - file      => Zend\Mail\Transport\File
         *      - null      => Zend\Mail\Transport\Null
         * Default value is Zend\Mail\Transport\Sendmail
         */
        'mail_adapter' => 'Zend\Mail\Transport\Smtp',

        /*
         * A service name which will return a Zend\Mail\Transport\TransportInterface instance to be used as the
         * transport object.
         * If this is set to something other than null, the 'mail_adapter' option will be ignored
         * Default value is null
         *
         * Note: Many configuration options are useful for standard transport objects only.
         * The mail_dapater_service is usefull to configure your own transport object with custom options
         */
        //'mail_adapter_service' => null,

        /************************
         * COMMON CONFIGURATION *
         ************************/

        /*
         * From email address of the email.
         * It would be used as SMTP username if mail_adapter is set to Zend\Mail\Transport\Smtp
         * and no smtp_user is provided
         * Default value is an empty string
         */
        //'from' => '',

        /*
         * From name to be displayed instead of from address.
         * Default value is an empty string
         */
        //'from_name' => '',

        /*
         * Destination addresses of sent emails. It can be an email address as string or an array of email addresses.
         * Default value is an empty array.
         */
        //'to' => array(),

        /*
         * Copy destination addresses of sent emails.
         * It can be an email address as string or an array of email addresses.
         * Default value is an empty array
         */
        //'cc' => array(),

        /*
         * Hidden copy destination addresses of sent emails.
         * It can be an email address as string or an array of email addresses.
         * Default value is an empty array
         */
        //'bcc' => array(),

        /*
         * Email subject.
         * Default value is an empty string
         */
        //'subject' => '',

        /*
         * Email body. Can be a string or hardcoded HTML.
         * If a more complex value is nedded it will have to be done in the code.
         * Default value is an empty string.
         */
        //'body' => '',

        /*
         * The charset to be set to the body when setting an HTML string body.
         * It will be ignored if the body is a plain text string.
         * Default value is 'utf-8'.
         */
        //'body_charset' => 'utf-8',

        /*
         * Defines information to create the email body from a view partial.
         * It defines template path and template params.
         * The path will be resolved by a view resolver, so you need to place mail templates inside a view
         * folder of one of your modules or customize your template map and template path stack.
         * Params will be a group of key-value pairs.
         * It has a use_template property wich tells if template should be used automatically,
         * ignoring anything defined at 'body' option. It is false by default.
         *
         * The 'children' property allows to define children for the template, in case you want to use layouts.
         * You can define any number of children. The key is the 'capture_to' property.
         * If you set the key 'content' to the child, you should have something like echo $this->content in you layout.
         * Any child can have its own children, so you can nest views into other views recursively.
         * By default no children are used
         */
        //'template' => array(
        //    'use_template'  => false,
        //    'path'          => 'ac-mailer/mail-templates/layout',
        //    'params'        => array(),
        //    'children'      => array(
        //        'content'   => array(
        //            'path'   => 'ac-mailer/mail-templates/mail',
        //            'params' => array(),
        //        )
        //    )
        //),

        /*
         * Attachments config.
         * Allows to define an array of files that will be attached to the message,
         * or even a directory that will be iterated to attach all found files.
         * Set directory will only be iterated if 'iterate' property is true and 'path' is a valid directory.
         * If 'recursive' is true all nested directories will be iterated too.
         * If both files and dir are set, all files will be merged without duplication
         * By default the files array is empty and the directory won't be iterated
         */
        //'attachments' => array(
        //    'files' => array(),
        //    'dir' => array(
        //        'iterate'   => false,
        //        'path'      => 'data/mail/attachments',
        //        'recursive' => false,
        //    ),
        //),

        /**********************
         * SMTP CONFIGURATION *
         **********************/

        /*
         * Hostname or IP address of mail server to be used.
         * Default value is localhost
         */
        'server' => 'smtp.gmail.com',

        /*
         * If Zend\Mail\Transport\Smtp adapter is used, this is the SMTP authentication identity.
         * If this is not set, from option is used.
         * Default value is an empty string
         */
        'smtp_user' => 'webpatte@gmail.com',

        /*
         * If Zend\Mail\Transport\Smtp adapter is used, this is the SMTP authentication credential.
         * Default value is an empty string
         */
        'smtp_password' => 'trinidade22',

        /*
         * If Zend\Mail\Transport\Smtp adapter is used, this defines the SSL type to be used, 'ssl' or 'tls'.
         * Boolean false should be used to disable SSL.
         * Default value is false
         */
        'ssl' => 'ssl',

        /*
         * If Zend\Mail\Transport\Smtp adapter is used, this is the connection class used for authentication.
         * Value can be one of 'smtp', 'plain', 'login' or 'crammd5'.
         * Default value is login. ZF2 default is smtp
         */
        'connection_class' => 'login',

        /*
         * If Zend\Mail\Transport\Smtp adapter is used, this is the SMTP server port
         */
        'port' => 465,

        /**********************
         * FILE CONFIGURATION *
         **********************/

        /*
         * If Zend\Mail\Transport\File adapter is used, thi sis the folder where the file is going to be saved
         * Default value is 'data/mail/output'
         */
        //'file_path' => 'data/mail/output',

        /**
         * A callable that will get the Zend\Mail\Transport\File object as an argument and should return the filename
         * Default value is null, in which case a default callable will be used
         */
        //'file_callback' => null,

    )

);
