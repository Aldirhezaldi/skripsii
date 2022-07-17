<?php

namespace App\Controller\Backend;

use App\Repository\DtTrainingRepository;
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
    public function index(BreacrumbBuilder $builder, DtTrainingRepository $dtTrainingRepository): Response
    {
        $builder->add('dash');
        $redirectPath = $this->getRoutingConfiguration()->getLoginSuccessRedirectPath($this->getUser()->getRoles());
        $conn = pg_connect("host=localhost port=5432 dbname=backup user=postgres password=buildstrike");
        
        $query = pg_query($conn, "SELECT * from data_training where jenis_pengadaan_id = '1'");
        $query1 = pg_query($conn, "SELECT * from data_training where jenis_pengadaan_id = '2'");
        $query2 = pg_query($conn, "SELECT * from data_training where jenis_pengadaan_id = '3'");
        $query3 = pg_query($conn, "SELECT * from data_training where jenis_pengadaan_id = '4'");

        $result_jp = pg_num_rows($query);
        $result_jp1 = pg_num_rows($query1);
        $result_jp2= pg_num_rows($query2);
        $result_jp3 = pg_num_rows($query3);

        $query4 = pg_query($conn, "SELECT * from data_training where sumber_dana_id = '1'");
        $query5 = pg_query($conn, "SELECT * from data_training where sumber_dana_id = '2'");
        $query6 = pg_query($conn, "SELECT * from data_training where sumber_dana_id = '3'");
        $query7 = pg_query($conn, "SELECT * from data_training where sumber_dana_id = '4'");
        
        $result_sd = pg_num_rows($query4);
        $result_sd1 = pg_num_rows($query5);
        $result_sd2= pg_num_rows($query6);
        $result_sd3 = pg_num_rows($query7);

        $query8 = pg_query($conn, "SELECT * from data_training where jenis_kontrak_id = '1'");
        $query9 = pg_query($conn, "SELECT * from data_training where jenis_kontrak_id = '2'");
        $query10 = pg_query($conn, "SELECT * from data_training where jenis_kontrak_id = '3'");
        $query11 = pg_query($conn, "SELECT * from data_training where jenis_kontrak_id = '4'");
        
        $result_jk = pg_num_rows($query8);
        $result_jk1 = pg_num_rows($query9);
        $result_jk2= pg_num_rows($query10);
        $result_jk3 = pg_num_rows($query11);

        $query12 = pg_query($conn, "SELECT * from data_training where pagu_id = '1'");
        $query13 = pg_query($conn, "SELECT * from data_training where pagu_id = '2'");
        $query14 = pg_query($conn, "SELECT * from data_training where pagu_id = '3'");
        
        $result_p = pg_num_rows($query12);
        $result_p1 = pg_num_rows($query13);
        $result_p2= pg_num_rows($query14);

        return $this->render('backend/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'title' => 'profile', 'back_path' => $redirectPath,
            'result_jp' => $result_jp,
            'result_jp1' => $result_jp1,
            'result_jp2' => $result_jp2,
            'result_jp3' => $result_jp3,
            'result_sd' => $result_sd,
            'result_sd1' => $result_sd1,
            'result_sd2' => $result_sd2,
            'result_sd3' => $result_sd3,
            'result_jk' => $result_jk,
            'result_jk1' => $result_jk1,
            'result_jk2' => $result_jk2,
            'result_jk3' => $result_jk3,
            'result_p' => $result_p,
            'result_p1' => $result_p1,
            'result_p2' => $result_p2,
        ]);
    }
}
