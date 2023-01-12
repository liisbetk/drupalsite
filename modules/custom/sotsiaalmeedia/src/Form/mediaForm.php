<?php

namespace Drupal\sotsiaalmeedia\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Executable\ExecutableException;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Form\FormInterface;
use \Drupal\Core\State\StateInterface;
use Drupal\sotsiaalmeedia\DbManager;


class mediaForm extends FormBase {



    public function getFormId()
    {
        return 'sotsiaalmeedia_mediaForm';
    }



    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $form['facebook'] = [
            '#type' => 'url',
            '#title' => $this
            ->t('Facebook url'),
            '#required' => FALSE,
            '#default_value' => '',
        ];
        $form['linkedin'] = [
            '#type' => 'url',
            '#title' => $this
            ->t('LinkedIn url'),
            '#required' => FALSE,
            '#default_value' =>  '',
        ];
        $form['twitter'] = [
            '#type' => 'url',
            '#title' => $this
            ->t('Twitter url'),
            '#required' => FALSE,
            '#default_value' =>  '',
        ];
        $form['instagram'] = [
            '#type' => 'url',
            '#title' => $this
            ->t('Instagram url'),
            '#required' => FALSE,
            '#default_value' =>  '',
        ];
        $form['google'] = [
            '#type' => 'url',
            '#title' => $this
            ->t('Google+ url'),
            '#required' => FALSE,
            '#default_value' =>  '',
        ];
        $form['pinterest'] = [
            '#type' => 'url',
            '#title' => $this
            ->t('pinterest url'),
            '#required' => FALSE,
            '#default_value' =>  '',
        ];
        $form['youtube'] = [
            '#type' => 'url',
            '#title' => $this
            ->t('Youtube url'),
            '#required' => FALSE,
            '#default_value' =>  '',
        ];
        $form['snapchat'] = [
            '#type' => 'url',
            '#title' => $this
            ->t('Snapchat url'),
            '#required' => FALSE,
            '#default_value' =>  '',
        ];
        $form['tiktok'] = [
            '#type' => 'url',
            '#title' => $this
            ->t('TikTok url'),
            '#required' => FALSE,
            '#default_value' =>  '',
        ];

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = [
          '#type' => 'submit',
          '#default_value' => $this->t('Lisa') ,
        ];

        return $form;
    }
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
     $conn = Database::getConnection();
        $conn->insert('sotsiaalmeedia_data')->fields(
            array(
                'facebook' => $form_state->getValue('facebook'),
                'linkedin' => $form_state->getValue('linkedin'),
                'twitter' => $form_state->getValue('twitter'),
                'instagram' => $form_state->getValue('instagram'),
                'google' => $form_state->getValue('google'),
                'pinterest' => $form_state->getValue('pinterest'),
                'youtube' => $form_state->getValue('youtube'),
                'snapchat' => $form_state->getValue('snapchat'),
                'tiktok' => $form_state->getValue('tiktok'),
            )
        )->execute();


    }
}
