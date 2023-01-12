<?php

namespace Drupal\sotsiaalmeedia\Controller;


class mediaController {

    public function socialmediaList() {

        $links = [
            ['name' => "Facebook"],
            ['name' => "LinkedIn"],
            ['name' => "Twitter"],
            ['name' => "Instagram"],
            ['name' => "Youtube"],
            ['name' => "Whatsapp"],
            ['name' => "Discord"],
            ['name' => "TikTok"],
            ['name' => "Reddit"]
        ];

        $socialmediaLinks = "";
        foreach ($links as $link) {
            $socialmediaLinks .= '<li>' . $link['name'] . '</li>';
        }

        return [
            '#type' => 'markup',
            '#markup' => '<ol>' . $socialmediaLinks . '</ol>',
        ];
    }
}