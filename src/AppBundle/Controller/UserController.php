<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use AppBundle\Controller\BaseController;

class UserController extends BaseController {

	/**
	 * @Rest\Get("/user")
	 */
	public function getAction()
	{
		//getRepo() in base class accepts bundle name and class name.
		//DO NOT add 'bundle' suffix to bundle name
		$restresult = $this->getRepo('App', 'User')->findAll();
		if ($restresult === null) {
			return new View("there are no users exist", Response::HTTP_NOT_FOUND);
		}
		return $restresult;
	}


	/**
	 * @Rest\Get("/user/{id}")
	 */
	public function idAction($id)
	{
		$singleresult = $this->getRepo('App','User')->find($id);
		if ($singleresult === null) {
			return new View("user not found", Response::HTTP_NOT_FOUND);
		}
		return $singleresult;
	}//idAction

	/**
	 * @Rest\Post("/user/")
	 */
	public function postAction(Request $request)
	{
		$data = new User;
		$name = $request->get('name');
		$role = $request->get('role');
		if(empty($name) || empty($role))
		{
			return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
		}
		$data->setName($name);
		$data->setRole($role);
		$em = $this->getDoctrine()->getManager();
		$em->persist($data);
		$em->flush();
		return new View("User Added Successfully", Response::HTTP_OK);
	}//postAction

	/**
	 * @Rest\Put("/user/{id}")
	 */
	public function updateAction($id,Request $request)
	{
		$name = $request->get('name');
		$role = $request->get('role');
		$sn = $this->getDoctrine()->getManager();
		$user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
		if (empty($user)) {
			return new View("user not found", Response::HTTP_NOT_FOUND);
		}
		elseif(!empty($name) && !empty($role)){
			$user->setName($name);
			$user->setRole($role);
			$sn->flush();
			return new View("User Updated Successfully", Response::HTTP_OK);
		}
		elseif(empty($name) && !empty($role)){
			$user->setRole($role);
			$sn->flush();
			return new View("role Updated Successfully", Response::HTTP_OK);
		}
		elseif(!empty($name) && empty($role)){
			$user->setName($name);
			$sn->flush();
			return new View("User Name Updated Successfully", Response::HTTP_OK);
		}
		else return new View("User name or role cannot be empty", Response::HTTP_NOT_ACCEPTABLE);
	}//updateAction


    /**
	 * @Rest\Delete("/user/{id}")
	 */
	public function deleteAction($id)
	{
		$data = new User;
		$sn = $this->getDoctrine()->getManager();
		$user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
		if (empty($user)) {
			return new View("user not found", Response::HTTP_NOT_FOUND);
		}
		else {
			$sn->remove($user);
			$sn->flush();
		}
		return new View("deleted successfully", Response::HTTP_OK);
	}
}
