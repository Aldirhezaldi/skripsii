<?php
namespace App\Controller\Backend;
// require_once __DIR__. '/vendor/autoload.php';

use App\Entity\DataTraining;
use App\Entity\DtTraining;
use App\Form\DataTrainingType;
use App\Repository\DataTrainingRepository;
use App\Filter\DataTrainingFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Extractors\ColumnPicker;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Transformers\NumericStringConverter;
use Rubix\ML\Transformers\OneHotEncoder;
use Kematjaya\Breadcrumb\Lib\Builder as BreacrumbBuilder;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Repository\DtTrainingRepository;
use Kematjaya\BaseControllerBundle\Controller\BaseLexikFilterController as BaseController;
use App\Service\FileUploader;
use PDO;
use PDOException;
use Psr\Log\LoggerInterface;
use App\Filter\DtTrainingFilterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/data/training", name="app_data_training_")
 */
class DataTrainingController extends BaseController
{
    /**
     * @Route("/index", name="index", methods={"GET", "POST"})
     */
    public function index(Request $request, DataTrainingRepository $dataTrainingRepository, BreacrumbBuilder $builder, string $uploadDir, FileUploader $uploader, LoggerInterface $logger): Response
    {
        $builder->add('Master');
        $builder->add('Data Training');

        $form = $this->createFormFilter(DataTrainingFilterType::class);
        $queryBuilder = $this->buildFilter($request, $form, $dataTrainingRepository->createQueryBuilder('this'));
        return $this->render('data_training/index.html.twig', [
            'kmj_user' => $this->getUser(),
            'data_trainings' => parent::createPaginator($queryBuilder, $request), 
            'filter' => $form->createView(),
        ]);
    }

    /**
     * @Route("/serial", name="serialization")
     */
    public function serial(): Response
    {
        $encoders = [new XmlEncoder(), new JsonEncoder(), new CsvEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $training = new DtTraining();

        $training->setPokja('hai');
        $excel = $serializer->serialize($training, 'csv');

        return $this->json($excel);
        // return $this->render('data_training/serial.html.twig', [
        //     'kmj_user' => $this->getUser(),
        // ]);
    }

    /**
     * @Route("/v2", name="indexv2", methods={"GET", "POST"})
     */
    public function trainingV2(Request $request, BreacrumbBuilder $builder, DtTrainingRepository $dtTrainingRepository): Response
    {
        $builder->add('Data Training V2');

        $form = $this->createFormFilter(DtTrainingFilterType::class);
        $queryBuilder = $this->buildFilter($request, $form, $dtTrainingRepository->createQueryBuilder('this'));
       
        return $this->render('data_training/v2.html.twig', [
            'kmj_user' => $this->getUser(),
            'dt_training' => parent::createPaginator($queryBuilder, $request), 
            'filter' => $form->createView(),
        ]);
    }

    /**
     * @Route("/coba", name="coba", methods={"GET", "POST"})
     */
    public function coba(Request $request, BreacrumbBuilder $builder, DtTrainingRepository $dtTrainingRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        $dataTesting =  new DataTesting();
        $builder->add('COba testing with import');

        $data = $dtTrainingRepository;
        $form = $this->createForm(DataTestingType::class, $dataTesting,[
            'action' => $this->generateUrl('app_backend_perhitungan_coba_post'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            // $dataTesting = $form->getData();
            $entityManagerInterface->persist($dataTesting);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_backend_perhitungan_coba_post');
        }

        return $this->render('data_training/coba.html.twig', [
            'kmj_user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/upload", name="upload_excel")
     */
    public function fileUpload(Request $request, string $uploadDir, FileUploader $uploader, LoggerInterface $logger)
    {
        $token = $request->get("token");

        if (!$this->isCsrfTokenValid('upload', $token))
        {
            $logger->info("CSRF failure");

            return new Response("Operation not allowed",  Response::HTTP_BAD_REQUEST,
                ['content-type' => 'text/plain']);
        }

        $file = $request->files->get('myfile');

        if (empty($file)) 
        {
            return new Response("No file specified",
                Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);
        }

        $inputFileName = $file->getClientOriginalName();
        $uploader->upload($uploadDir, $file, $inputFileName);

        $targetPath = '../var/uploads/'.$inputFileName;

        $conn = pg_connect("host=localhost port=5432 dbname=backup user=postgres password=buildstrike");

        /**  Identify the type of $inputFileName  **/
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($targetPath);

        /**  Create a new Reader of the type that has been identified  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($targetPath);

        $worksheet = $spreadsheet->getActiveSheet();

        $highestRow = $worksheet->getHighestRow(); // total number of rows

        $highestColumn = $worksheet->getHighestColumn(); // total number of columns

        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

        if ($highestRow <= 0) {
            Exit ('There is no data in the Excel table');
        }

        for ($row = 1; $row <= $highestRow; ++$row) {
            
            $pokja = ("SELECT id FROM pokja WHERE nama_pokja = '". pg_escape_string($conn, $worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue())."'"); 
            $jenis_pengadaan = ("SELECT id FROM jenis_pengadaan WHERE nama_jenis_pengadaan = '". pg_escape_string($conn, $worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue())."'"); 
            $sumber_dana = ("SELECT id FROM sumber_dana WHERE nama_sumber_dana = '". pg_escape_string($conn, $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue())."'"); 
            $jenis_kontrak = ("SELECT id FROM jenis_kontrak WHERE nama_jenis_kontrak = '". pg_escape_string($conn, $worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue())."'");
            $pagu = ("SELECT id FROM pagu WHERE range_pagu = '". pg_escape_string($conn, $worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue())."'");  

            $query = "insert into data_training(pokja_id, jenis_pengadaan_id, sumber_dana_id, jenis_kontrak_id, pagu_id) VALUES ((".$pokja."),(".$jenis_pengadaan."),(".$sumber_dana."),(".$jenis_kontrak."),(".$pagu."))";

        try {
            $result = pg_query($conn, $query);
            if ($result == true){
                echo ("<script LANGUAGE='JavaScript'>
                        window.alert('Berhasil Mengimport Data Training');
                        window.location.href='index';
                        </script>");
            }else{
                var_dump($result) . var_dump($conn) . var_dump($query);
            }

        } catch (Exception $e) {
        echo $e->getMessage();
        }
    }
        return new Response(" File uploaded",  Response::HTTP_OK, ['content-type' => 'text/plain']);  

    }
    
    // /**
    //  * @Route("/cekConn", name="conn")
    //  */
    // public function conn()
    // {
    //     $cn = new PDO("pgsql:host=localhost;port=5432;dbname=backup;user=postgres;password=buildstrike");
    //     if($cn)
    //     {
    //         echo "konek";
    //     }
    // }

    /**
     * @Route("/create", name="create", methods={"GET","POST"})
     */
    public function create(Request $request): Response
    {
        $dataTraining = new DataTraining();
        
        $form = $this->createForm(DataTrainingType::class, $dataTraining, [
        'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_data_training_create')]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
                
        return $this->render('data_training/form.html.twig', [
            'data_training' => $dataTraining,
            'form' => $form->createView(), 'title' => 'create'
        ]);
    }

    /**
     * @Route("/{id}/show", name="show", methods={"GET"})
     */
    public function show(DataTraining $dataTraining): Response
    {
        return $this->render('data_training/show.html.twig', [
            'data_training' => $dataTraining,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DataTraining $dataTraining): Response
    {
        $form = $this->createForm(DataTrainingType::class, $dataTraining, [
        'attr' => ['id' => 'ajaxForm', 'action' => $this->generateUrl('app_data_training_edit', ['id' => $dataTraining->getId()])]
        ]);
        $result = parent::processFormAjax($request, $form);
        if ($result['process']) {
            return $this->json($result);
        }
         
        return $this->render('data_training/form.html.twig', [
            'data_training' => $dataTraining,
            'form' => $form->createView(), 'title' => 'edit'
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete", methods={"DELETE","POST"})
     */
    public function delete(Request $request, DataTraining $dataTraining): Response
    {
        $tokenName = 'delete'.$dataTraining->getId();
        parent::doDelete($request, $dataTraining, $tokenName);
        
        return $this->redirectToRoute('app_data_training_index');
    }
}
