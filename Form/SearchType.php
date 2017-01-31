<?php

/*
 * This file is part of the AntibodyBundle.
 *
 * Copyright (c) 2017 BlueMesa LabDB Contributors <labdb@bluemesa.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bluemesa\Bundle\AntibodyBundle\Form;

use Bluemesa\Bundle\AntibodyBundle\Search\SearchQuery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * SearchType class
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class SearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['simple']) {
            $builder->add('terms', TextType::class, array(
                    'required' => false,
                    'horizontal' => false,
                    'label_render' => false,
                    'attr' => array(
                        'form' => 'search-form',
                        'placeholder' => 'Search'
                    )
                )
            )->add('aborder', HiddenType::class, array('required' => false)
            )->add('type', HiddenType::class, array('required' => false));
        } else {
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
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars = array_merge($view->vars, array(
            'simple' => $options['simple']
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => SearchQuery::class,
                'simple' => false
            )
        );
    }
}
