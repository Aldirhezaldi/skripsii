<?php

namespace App\Controller\Backend;

use Symfony\Component\Routing\Annotation\Route;
use Kematjaya\UserBundle\Controller\AbstractKmjController;
use Symfony\Component\HttpFoundation\Response;
use Kematjaya\Breadcrumb\Lib\Builder as BreacrumbBuilder;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;


/**
 * @Route("/dashboard", name="dashboard_")
 */
class DashboardController extends AbstractKmjController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(BreacrumbBuilder $builder, ChartBuilderInterface $chartBuilder): Response
    {
        $builder->add('dash');
        $redirectPath = $this->getRoutingConfiguration()->getLoginSuccessRedirectPath($this->getUser()->getRoles());
        
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $this->render('backend/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'title' => 'profile', 'back_path' => $redirectPath,
            'chart' => $chart,
        ]);
    }
}
