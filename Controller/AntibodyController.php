<?php

/*
 * This file is part of the AntibodyBundle.
 *
 * Copyright (c) 2016 BlueMesa LabDB Contributors <labdb@bluemesa.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bluemesa\Bundle\AntibodyBundle\Controller;

use Bluemesa\Bundle\CrudBundle\Controller\Annotations as CRUD;
use Bluemesa\Bundle\CrudBundle\Controller\CrudControllerTrait;
use FOS\RestBundle\Controller\Annotations as REST;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * AntibodyController class
 *
 * @author Radoslaw Kamil Ejsmont <radoslaw@ejsmont.net>
 *
 * @REST\Prefix("/antibodies")
 * @REST\NamePrefix("bluemesa_antibody_")
 * @CRUD\Controller()
 */
class AntibodyController extends Controller
{
    use CrudControllerTrait;

    /**
     * @CRUD\Action("index")
     * @CRUD\Paginate(25)
     * @CRUD\Filter("Bluemesa\Bundle\AntibodyBundle\Filter\AntibodyFilter", redirectRoute="bluemesa_antibody_index_type_sort")
     * @REST\View()
     * @REST\Get("", defaults={"_format" = "html"}))
     * @REST\Get("/{aborder}/{type}", name="_type",
     *     requirements={"aborder" = "primary|secondary|all", "type" = "monoclonal|polyclonal|all"},
     *     defaults={"_format" = "html"}))
     * @REST\Get("/sort/{sort}/{order}", name="_sort",
     *     requirements={"sort" = "antigen|type"},
     *     defaults={"_format" = "html", "type" = "all", "sort" = "name", "order" = "asc"})
     * @REST\Get("/{aborder}/{type}/sort/{sort}/{order}", name="_type_sort",
     *     requirements={"aborder" = "primary|secondary|all",
     *         "type" = "monoclonal|polyclonal|all",
     *         "sort" = "antigen|type"},
     *     defaults={"_format" = "html", "type" = "all", "order" = "asc"})
     *
     * @param  Request  $request
     * @return View
     */
    public function indexAction(Request $request)
    {
        return $this->getCrudHandler()->handle($request);
    }

    /**
     * @CRUD\Action("show")
     * @REST\View()
     * @REST\Get("/{id}", requirements={"id"="\d+"}, defaults={"_format" = "html"})
     *
     * @param  Request  $request
     * @return View
     */
    public function showAction(Request $request)
    {
        return $this->getCrudHandler()->handle($request);
    }

    /**
     * @CRUD\Action("new")
     * @REST\View()
     * @REST\Route("/new", methods={"GET", "PUT"}, defaults={"_format" = "html"})
     * @REST\Put("", name="_rest", defaults={"_format" = "html"})
     *
     * @param  Request     $request
     * @return View
     */
    public function newAction(Request $request)
    {
        return $this->getCrudHandler()->handle($request);
    }

    /**
     * @CRUD\Action("edit")
     * @REST\View()
     * @REST\Route("/{id}/edit", methods={"GET", "POST"}, requirements={"id"="\d+"}, defaults={"_format" = "html"})
     * @REST\Post("/{id}", name="_rest", requirements={"id"="\d+"}, defaults={"_format" = "html"})
     *
     * @param  Request     $request
     * @return View
     */
    public function editAction(Request $request)
    {
        return $this->getCrudHandler()->handle($request);
    }

    /**
     * @CRUD\Action("delete")
     * @REST\View()
     * @REST\Route("/{id}/delete", methods={"DELETE", "POST"}, requirements={"id"="\d+"}, defaults={"_format" = "html"})
     * @REST\Delete("/{id}", name="_rest", requirements={"id"="\d+"}, defaults={"_format" = "html"})
     *
     * @param  Request     $request
     * @return View
     */
    public function deleteAction(Request $request)
    {
        return $this->getCrudHandler()->handle($request);
    }
}
