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

use Bluemesa\Bundle\AntibodyBundle\Search\SearchQuery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * AdvancedSearchType class
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class AdvancedSearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('terms', TextType::class, array(
                'label' => 'Include terms',
                'required' => false,
                'attr' => array(
                    'class' => 'input-block-level',
                    'placeholder' => 'separate terms with space'
                )
            )
        )->add('excluded', TextType::class, array(
                'label' => 'Exclude terms',
                'required' => false,
                'attr' => array(
                    'class' => 'input-block-level',
                    'placeholder' => 'separate terms with space'
                )
            )
        )->add('aborder', ChoiceType::class, array(
                'label' => 'Order',
                'choices' => array(
                    'Primary' => 'primary',
                    'Secondary' => 'secondary'
                ),
                'expanded' => true,
                'placeholder' => 'All',
                'empty_data' => 'all',
                'required' => false
            )
        )->add('type', ChoiceType::class, array(
                'label' => '',
                'choices' => array(
                    'Monoclonal' => 'monoclonal',
                    'Polyclonal' => 'polyclonal'
                ),
                'expanded' => true,
                'placeholder' => 'All',
                'empty_data' => 'all',
                'required' => false
            )
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => SearchQuery::class
            )
        );
    }
}
