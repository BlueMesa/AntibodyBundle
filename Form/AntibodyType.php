<?php

/*
 * Copyright 2013 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Bluemesa\Bundle\AntibodyBundle\Form;

use Bluemesa\Bundle\AntibodyBundle\Entity\Antibody;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * AntibodyType class
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class AntibodyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('antigen', TextType::class, array(
                        'label'     => 'Antigen'))
                ->add('targetSpecies', TextType::class, array(
                        'label'     => 'Target species'))
                ->add('hostSpecies', TextType::class, array(
                        'label'     => 'Host species'))
                ->add('order', ChoiceType::class, array(
                        'label'     => 'Type',
                        'required'  => true,
                        'choices' => array(
                            'Primary' => 'primary',
                            'Secondary' => 'secondary',
                        )))
                ->add('type', ChoiceType::class, array(
                        'label_render' => false,
                        'required'  => true,
                        'choices' => array(
                            'Monoclonal' => 'monoclonal',
                            'Polyclonal' => 'polyclonal',
                        )))
                ->add('class', ChoiceType::class, array(
                        'label_render' => false,
                        'required'  => true,
                        'choices' => array(
                            'IgG' => 'IgG',
                            'IgM' => 'IgM',
                            'Nanobody' => 'nanobody',
                        )))
                ->add('clone', TextType::class, array(
                        'label'     => 'Clone'))
                ->add('size', NumberType::class, array(
                        'label'     => 'Size',
                        'attr'      => array('class' => 'input-small'),
                        'widget_addon_append' => array(
                                'text' => 'kDa',
                        )))
                ->add('temperature', NumberType::class, array(
                        'scale'     => 2,
                        'label'     => 'Temperature',
                        'required'  => false,
                        'attr'      => array('class' => 'input-small'),
                        'widget_addon_append' => array(
                                'text' => '℃',
                        )))
                ->add('notes', TextareaType::class, array(
                        'label' => 'Notes',
                        'required' => false))
                ->add('vendor', TextType::class, array(
                        'label' => 'Vendor',
                        'required' => false))
                ->add('infoURL', UrlType::class, array(
                        'label' => 'Info URL',
                        'required' => false,
                        'attr' => array('placeholder' => 'Paste address here')))
                ->add('applications', CollectionType::class, array(
                         'entry_type' => ApplicationType::class,
                         'allow_add' => true,
                         'allow_delete' => true,
                         'by_reference' => false,
                         'prototype' => true,
                         'show_legend' => false,
                         'label' => 'Applications',
                         'widget_add_btn' => array('label' => false, 'icon' => 'plus'),
                         'entry_options' => array(
                             'label' => false,
                             'widget_remove_btn' => array('label' => false, 'icon' => 'times')
                         )
                       )
                     );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Antibody::class
        ));
    }
}
