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

namespace Bluemesa\Bundle\AntibodyBundle\Search;

use Bluemesa\Bundle\AntibodyBundle\Entity\Antibody;
use JMS\Serializer\Annotation as Serializer;

use Bluemesa\Bundle\SearchBundle\Search\ACLSearchQuery;

/**
 * SearchQuery class
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class SearchQuery extends ACLSearchQuery
{
    /**
     * @Serializer\Type("string")
     * 
     * @var string
     */
    protected $aborder;

    /**
     * @Serializer\Type("string")
     *
     * @var string
     */
    protected $type;
    
    /**
     * {@inheritdoc}
     */
    public function __construct($advanced = false) {
        parent::__construct($advanced);
        $this->aborder = null;
        $this->type = null;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEntityClass() {
        return Antibody::class;
    }

    /**
     * Get order
     * 
     * @return string
     */
    public function getAborder() {
        if (empty($this->aborder)) {
            return 'all';
        }
        
        return $this->aborder;
    }

    /**
     * Set order
     * 
     * @param string $aborder
     */
    public function setAborder($aborder) {
        $this->aborder = $aborder;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        if (empty($this->type)) {
            return 'all';
        }

        return $this->type;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
