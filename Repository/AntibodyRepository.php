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

namespace Bluemesa\Bundle\AntibodyBundle\Repository;

use Bluemesa\Bundle\AntibodyBundle\Filter\AntibodyFilter;
use Bluemesa\Bundle\CoreBundle\Filter\SortFilterInterface;
use Bluemesa\Bundle\SearchBundle\Repository\SearchableRepository;
use Bluemesa\Bundle\SearchBundle\Search\SearchQueryInterface;
use Bluemesa\Bundle\AntibodyBundle\Search\SearchQuery;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\Expr\Andx;

/**
 * AntibodyRepository
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 */
class AntibodyRepository extends SearchableRepository
{
    /**
     * {@inheritdoc}
     */
    public function createIndexQueryBuilder()
    {
        $qb = parent::createIndexQueryBuilder();

        if ($this->filter instanceof AntibodyFilter) {
            $expr = $this->getAntibodyTypeExpression($this->filter->getType());
            if (null !== $expr) {
                $qb->andWhere($expr);
            }
            $expr = $this->getAntibodyOrderExpression($this->filter->getAborder());
            if (null !== $expr) {
                $qb->andWhere($expr);
            }
        }

        if ($this->filter instanceof SortFilterInterface) {
            $order = ($this->filter->getOrder() == 'desc') ? 'DESC' : 'ASC';
            switch ($this->filter->getSort()) {
                case 'name':
                    $qb->orderBy('e.name', $order);
                    break;
                case 'type':
                    $qb->orderBy('e.type', $order);
                    break;
                case 'host':
                    $qb->orderBy('e.host', $order);
                    break;
                case 'target':
                    $qb->orderBy('e.target', $order);
                    break;
            }
        }

        return $qb;
    }

    /**
     * {@inheritdoc}
     */
    protected function getSearchExpression(SearchQueryInterface $search)
    {
        $expr = parent::getSearchExpression($search);

        if (($search instanceof SearchQuery)&&($expr instanceof Andx)) {
            $expr->add($this->getAntibodyOrderExpression($search->getAborder()));
            $expr->add($this->getAntibodyTypeExpression($search->getType()));
        }

        return $expr;
    }

    /**
     * @param  string $type
     * @return Expr
     */
    protected function getAntibodyTypeExpression($type)
    {
        $eb = $this->getEntityManager()->getExpressionBuilder();

        switch($type) {
            case 'all':
                $expr = null;
                break;
            case 'monoclonal':
                $expr = $eb->eq('e.type', '\'monoclonal\'');
                break;
            case 'polyclonal':
                $expr = $eb->eq('e.type', '\'polyclonal\'');
                break;
            default:
                $expr = $eb->eq('e.type', '\'' . $type . '\'');
        }

        return $expr;
    }

    /**
     * @param  string $aborder
     * @return Expr
     */
    protected function getAntibodyOrderExpression($aborder)
    {
        $eb = $this->getEntityManager()->getExpressionBuilder();

        switch($aborder) {
            case 'all':
                $expr = null;
                break;
            case 'primary':
                $expr = $eb->eq('e.order', '\'primary\'');
                break;
            case 'secondary':
                $expr = $eb->eq('e.order', '\'secondary\'');
                break;
            default:
                $expr = $eb->eq('e.order', '\'' . $aborder . '\'');
        }

        return $expr;
    }

    /**
     * {@inheritdoc}
     */
    protected function getSearchFields(SearchQueryInterface $search)
    {
        $fields = array('e.antigen', 'e.targetSpecies', 'e.hostSpecies');
        
        return $fields;
    }
}
