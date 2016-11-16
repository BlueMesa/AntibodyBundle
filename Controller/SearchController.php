<?php

/*
 * Copyright 2011 Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
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

namespace Bluemesa\Bundle\AntibodyBundle\Controller;


use Bluemesa\Bundle\AclBundle\Controller\SecureController;
use Bluemesa\Bundle\AclBundle\DependencyInjection\AuthorizationCheckerAwareTrait;
use Bluemesa\Bundle\AclBundle\DependencyInjection\TokenStorageAwareTrait;
use Bluemesa\Bundle\AntibodyBundle\Search\SearchQuery;
use Bluemesa\Bundle\AntibodyBundle\Form\SearchType;
use Bluemesa\Bundle\AntibodyBundle\Form\AdvancedSearchType;
use Bluemesa\Bundle\SearchBundle\Controller\SearchController as BaseSearchController;
use FOS\RestBundle\Controller\Annotations as REST;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Search controller for the antibody bundle
 *
 * @REST\Prefix("/antibodies/search")
 * @REST\NamePrefix("bluemesa_antibody_search_")
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class SearchController extends BaseSearchController
{
    use TokenStorageAwareTrait, AuthorizationCheckerAwareTrait;

    /**
     * Render advanced search form
     *
     * @REST\Get("", defaults={"_format" = "html"}))
     * @REST\View()
     *
     * @return Response
     */
    public function advancedAction()
    {
        return parent::advancedAction();
    }

    /**
     * Render quick search form
     *
     * @REST\Get("/simple", defaults={"_format" = "html"}))
     * @REST\View()
     *
     * @return Response
     */
    public function searchAction()
    {
        return parent::searchAction();
    }

    /**
     * Handle search result
     *
     * @REST\Get("/result", defaults={"_format" = "html"}))
     * @REST\Post("/result", defaults={"_format" = "html"}))
     * @REST\View()
     *
     * @param  Request $request
     * @return array
     */
    public function resultAction(Request $request)
    {
        return parent::resultAction($request);
    }

    /**
     * {@inheritdoc}
     */
    protected function getSearchForm()
    {
        return SearchType::class;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function getAdvancedSearchForm()
    {
        return AdvancedSearchType::class;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function getSearchRealm()
    {
        return 'bluemesa_antibodies';
    }
    
    /**
     * {@inheritdoc}
     */
    protected function createSearchQuery($advanced = false)
    {
        $searchQuery = new SearchQuery($advanced);
        $searchQuery->setTokenStorage($this->getTokenStorage());
        $searchQuery->setAuthorizationChecker($this->getAuthorizationChecker());
        
        return $searchQuery;
    }

    /**
     * {@inheritdoc}
     */
    protected function loadSearchQuery()
    {
        $searchQuery = parent::loadSearchQuery();
        
        if (! $searchQuery instanceof SearchQuery) {
            throw $this->createNotFoundException();
        }
        
        $searchQuery->setTokenStorage($this->getTokenStorage());
        
        return $searchQuery;
    }
}
