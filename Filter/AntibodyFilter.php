<?php

/*
 * This file is part of the AntibodyBundle.
 *
 * Copyright (c) 2016 BlueMesa LabDB Contributors <labdb@bluemesa.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bluemesa\Bundle\AntibodyBundle\Filter;

use Bluemesa\Bundle\CrudBundle\Filter\RedirectFilterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Bluemesa\Bundle\AclBundle\Filter\SecureListFilter;
use Bluemesa\Bundle\CoreBundle\Filter\SortFilterInterface;

/**
 * AntibodyFilter
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class AntibodyFilter extends SecureListFilter implements SortFilterInterface, RedirectFilterInterface  {

    /**
     * @var string
     */
    protected $sort;

    /**
     * @var string
     */
    protected $order;

    /**
     * @var string
     */
    protected $aborder;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var bool
     */
    protected $redirect;


    /**
     * {@inheritdoc}
     */
    public function __construct(Request $request = null,
                                AuthorizationCheckerInterface $authorizationChecker = null,
                                TokenStorageInterface $tokenStorage = null)
    {
        parent::__construct($request, $authorizationChecker, $tokenStorage);
        if (null !== $request) {
            $this->setAccess($request->get('access', 'public'));
            $this->setSort($request->get('sort', 'antigen'));
            $this->setOrder($request->get('order', 'asc'));
            $this->setAborder($request->get('aborder', 'all'));
            $this->setType($request->get('type', 'all'));
            $this->redirect = ($request->get('resolver', 'off') == 'on');
        } else {
            $this->access = 'public';
            $this->sort = 'antigen';
            $this->order = 'asc';
            $this->aborder = 'all';
            $this->type = 'all';
            $this->redirect = false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * {@inheritdoc}
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getAborder()
    {
        return $this->aborder;
    }

    /**
     * @param string $aborder
     */
    public function setAborder($aborder)
    {
        $this->aborder = $aborder;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return array(
            'aborder' => $this->getAborder(),
            'type'    => $this->getType(),
            'sort'    => $this->getSort(),
            'order'   => $this->getOrder()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function needRedirect()
    {
        return $this->redirect;
    }
}
