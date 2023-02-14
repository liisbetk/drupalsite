<?php

namespace Drupal\custom_config_form\Form;


use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class CustomConfigForm extends ConfigFormBase {

    /**
     * settings variable
     */

    const CONFIGNAME = "custom_config_form.settings";

    /**
    * {@inheritDoc}
    */

    public function getFormId()
    {
        return "custom_config_form.settings";
    }

    /**
    *{@inheritDoc}
    */

    protected function getEditableConfigNames()
    {
        return [
            static::CONFIGNAME,
        ];
    }

    /**
     * {@inheritDoc}
     */


    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config(static::CONFIGNAME);

        $form['firstname'] = [
            '#type' => 'textfield',
            '#title' => $this->t('First name'),
            '#default_value' => $config->get("firstname"),
        ];
        $form['lastname'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Last name'),
            '#default_value' => $config->get("lastname"),
        ];

        return Parent::buildForm($form, $form_state);
    }

    /**
     *{@inheritDoc}
     */

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $config = $this->config(static::CONFIGNAME);
        $config->set("firstname", $form_state->getValue('firstname'));
        $config->set("lastname", $form_state->getValue('lastname'));
        $config->save();
    }

}