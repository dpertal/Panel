### Admin Panel for Morfy 1.05


---


**Config file settings:**

    <?php
        return array(
            'site_url' => 'http://localhost:8080/morfy',
            'site_charset' => 'UTF-8',
            'site_timezone' => 'Europe/Brussels',
            'site_theme' => 'default',
            'site_title' => 'demo',
            'site_description' => 'this is demo',
            'site_keywords' => 'nakome',
            'email' => 'demo@gmail.com',

            // panel options
            'Panel_lang' => 'es', // language es or en
            'password' => 'demo',
            'secret_key_1' => '12sdf3321a321asdfas', // secret key for md5
            'secret_key_2' => '4561dsf232gdfd1asdf3', // secret key for md5
            'Panel_Images' => 'full', // name of full image folder
            'Panel_Thumbnails' => 'tumb', // name of tumb images


            'plugins' => array(
                'markdown',
                'sitemap',
                'panel'
            ),
        );
      		