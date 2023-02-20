<?php

namespace Drupal\socialmedia\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SocialmediaForm extends ConfigFormBase{
    /**
     *{@inheritDoc}
     */
    public function getFormId()
    {
        return 'socialmedia.config_form';
    }

    /**
     *{@inheritDoc}
     */

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = parent::buildForm($form, $form_state);
        $config = $this->config('socialmedia.settings');

        $links = [
            ['facebook', 'Facebook'],
            ['linkedin', 'Linkedin'],
            ['twitter', 'Twitter'],
            ['instagram', 'Instagram'],
            ['google', 'Google'],
            ['pinterest', 'Pinterest'],
            ['youtube', 'Youtube'],
            ['snapchat', 'Snapchat'],
            ['reddit', 'Reddit'],
        ];

        for ($i = 0; $i < count($links); $i++) {
            $form[$links[$i][0]] = [
                '#type' =>'textfield',
                '#title' => $this->t($links[$i][1]),
                '#default_value' => $config->get('socialmedia.' . $links[$i][0]),
                '#attributes' =>[
                    'placeholder' => $this->t('username'),
                ],
            ];
        }
        return $form;
    }
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $config = $this->config('socialmedia.settings');

        $links = [
            'facebook',
            'linkedin',
            'twitter',
            'instagram',
            'google',
            'pinterest',
            'youtube',
            'snapchat',
            'reddit',
        ];

        for ($i = 0; $i < count($links); $i++) {
            $config->set('socialmedia.' . $links[$i], $form_state->getValue($links[$i]));

        }
        $config->save();

        return parent::submitForm($form , $form_state);
    }

    /**
     *{@inheritDoc}
     */

     protected function getEditableConfigNames()
     {
        return [
            'socialmedia.settings',
        ];
     }
}