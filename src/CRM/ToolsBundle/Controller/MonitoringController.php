<?php
/**
 * Created by PhpStorm.
 * User: zkissarli
 * Date: 30/05/2017
 * Time: 09:42
 */

namespace CRM\ToolsBundle\Controller;


use CRM\ToolsBundle\Entity\LogsView;
use CRM\ToolsBundle\Form\LogsViewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use CRM\ToolsBundle\Entity\GraphName;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MonitoringController extends Controller
{

    public function graphAction(Request $request)
    {

        $end_date = new \DateTime();

        $start_date = new \DateTime();
        $start_date->modify('-7 day');

        $start_date_display= $start_date->format('Y-m-d');
        $end_date_display= $end_date->format('Y-m-d');

        $data_array_perf = $this->getDataPerformance($start_date, $end_date, $start_date_display, $end_date_display);

        /*Creat the date form*/
        $logsView = new LogsView();
        $form = $this->createForm (new LogsViewType(), $logsView);

        $request = $this->getRequest();
        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            $date_picker = $form->getData();

            $start_date = $date_picker->getStartDate();
            $start_date_picker = $start_date->format('Y-m-d');

            $end_date = $date_picker->getEndDate();
            $end_date_picker = $end_date->format('Y-m-d');
            if($start_date_picker > $end_date_picker){
                throw new NotFoundHttpException('La "date début" doit être supèrieur à la "date fin"');
            }

            $data_array_perf = $this->getDataPerformance($start_date, $end_date, $start_date_picker, $end_date_picker);

             return $this->render('CRMToolsBundle:Monitoring:graphPerformance.html.twig', array(
                 'startDate'  => $start_date_picker,
                 'endDate'    => $end_date_picker,
                 'date_array' => $data_array_perf['date_array'],
                 'week_array' => $data_array_perf['week_array'],
                 'result_graph_avg' => $data_array_perf['result_graph_avg'],
                 'result_nb_contacts' => $data_array_perf['result_nb_contacts'],
                 'result_nb_contacts_min' => $data_array_perf['result_nb_contacts_min'],
                 'result_nb_events' => $data_array_perf['result_nb_events'],
                 'result_nb_booking_midas' => $data_array_perf['result_nb_booking_midas'],
                 'result_nb_booking_midas_min' => $data_array_perf['result_nb_booking_midas_min'],
                 'result_nb_booking_ap' => $data_array_perf['result_nb_booking_ap'],
                 'result_nb_booking_ap_min' => $data_array_perf['result_nb_booking_ap_min'] ,
                 'result_nb_booking_bboss' => $data_array_perf['result_nb_booking_bboss'] ,
                 'result_nb_booking_bboss_min' => $data_array_perf['result_nb_booking_bboss_min'] ,
                 'form'=>$form->createView(),
             ));
        }
        
        return $this->render('CRMToolsBundle:Monitoring:graphPerformance.html.twig', array(
            'startDate'  => $start_date_display,
            'endDate'    => $end_date_display,
            'date_array' => $data_array_perf['date_array'],
            'week_array' => $data_array_perf['week_array'],
            'result_graph_avg' => $data_array_perf['result_graph_avg'],
            'result_nb_contacts' => $data_array_perf['result_nb_contacts'],
            'result_nb_contacts_min' => $data_array_perf['result_nb_contacts_min'],
            'result_nb_events' => $data_array_perf['result_nb_events'],
            'result_nb_booking_midas' => $data_array_perf['result_nb_booking_midas'],
            'result_nb_booking_midas_min' => $data_array_perf['result_nb_booking_midas_min'],
            'result_nb_booking_ap' => $data_array_perf['result_nb_booking_ap'],
            'result_nb_booking_ap_min' => $data_array_perf['result_nb_booking_ap_min'] ,
            'result_nb_booking_bboss' => $data_array_perf['result_nb_booking_bboss'] ,
            'result_nb_booking_bboss_min' => $data_array_perf['result_nb_booking_bboss_min'] ,
            'form'=>$form->createView(),
        ));
    }

    public function getDataPerformance($start_date, $end_date, $start_date_display, $end_date_display)
    {
        $data_array_perf = array();
        $date_array = array();
        
        while ($start_date <= $end_date) {
            array_push($date_array, $start_date->format('Y-m-d'));
            $start_date->modify('+1 day');
        }
        
        $data_array_perf['date_array'] = $date_array;
        
        $start_date = $start_date->modify('-8 day');

        $week_array = array();

        $start_week_1 = clone $start_date->modify('-8 day');
        $start_week_1 = $start_week_1->format('Y-m-d');
        $end_week_1 = clone $start_date->modify('+7 day');
        $end_week_1 = $end_week_1->format('Y-m-d');
        $week_array[] = array(
            '0' => $start_week_1,
            '1' => $end_week_1,
        );

        $start_month = clone $start_date->modify('-23 day');
        $start_month = $start_month->format('Y-m-d');
        $end_month = clone $end_date;
        $end_month = $end_month->format('Y-m-d');
        $week_array[] = array(
            '0' => $start_month,
            '1' => $end_month,
        );

        $end_month_1 = clone $start_date;
        $end_month_1 = $end_month_1->format('Y-m-d');
        $start_month_1 = clone $start_date->modify('-31 day');
        $start_month_1 = $start_month_1->format('Y-m-d');
        $week_array[] = array(
            '0' => $start_month_1,
            '1' => $end_month_1,
        );

        $data_array_perf['week_array'] = $week_array;
//        var_dump($data_array_perf);die;

        $em = $this->getDoctrine()->getManager();

        /*Query for displaying the graph average*/
        $result_graph_avg = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayGraphTable($start_date_display, $end_date_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);
        $data_array_perf['result_graph_avg'] = $result_graph_avg;

        /*Query for displaying NB Contacts*/
        $result_nb_contacts = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbContacts($start_date_display, $end_date_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);
        $data_array_perf['result_nb_contacts'] = $result_nb_contacts;


        /*Query for displaying NB Contacts / Min*/
        $result_nb_contacts_min = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbContactsMin($start_date_display, $end_date_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);
        $data_array_perf['result_nb_contacts_min'] = $result_nb_contacts_min;


        /*Query for displaying NB Events*/
        $result_nb_events = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbEvents($start_date_display, $end_date_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);
        $data_array_perf['result_nb_events'] = $result_nb_events;

        /*Query for displaying NB Booking Midas*/
        $result_nb_booking_midas = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbBookingMidas($start_date_display, $end_date_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);
        $data_array_perf['result_nb_booking_midas'] = $result_nb_booking_midas;

        /*Query for displaying NB Booking Midas / Min*/
        $result_nb_booking_midas_min = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbBookingMidasMin($start_date_display, $end_date_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);
        $data_array_perf['result_nb_booking_midas_min'] = $result_nb_booking_midas_min;

        /*Query for displaying NB Booking AP*/
        $result_nb_booking_ap = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbBookingAp($start_date_display, $end_date_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);
        $data_array_perf['result_nb_booking_ap'] = $result_nb_booking_ap;

        /*Query for displaying NB Booking AP / Min*/
        $result_nb_booking_ap_min = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbBookingApMin($start_date_display, $end_date_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);
        $data_array_perf['result_nb_booking_ap_min'] = $result_nb_booking_ap_min;

        /*Query for displaying NB Booking BBOSS*/
        $result_nb_booking_bboss = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbBookingBboss($start_date_display, $end_date_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);
        $data_array_perf['result_nb_booking_bboss'] = $result_nb_booking_bboss;

        /*Query for displaying NB Booking BBOSS / Min*/
        $result_nb_booking_bboss_min = $em->getRepository('CRMToolsBundle:LogsView')
            ->displayNbBookingBbossMin($start_date_display, $end_date_display, $start_week_1, $end_week_1, $start_month, $end_month,
                $start_month_1, $end_month_1, $date_array);
        $data_array_perf['result_nb_booking_bboss_min'] = $result_nb_booking_bboss_min;

        return $data_array_perf;
    }
}
