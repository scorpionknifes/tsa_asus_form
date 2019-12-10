<?php
class ControllerInformationAsusFormComplete extends Controller
{

    public function index()
    {
        
        $name = $email = $gender = $comment = $website = "";
        $this->load->language('information/asusform');
        $this->document->setTitle($this->language->get('meta_title'));
        $this->document->setDescription($this->language->get('meta_description'));
        $this->document->setKeywords($this->language->get('meta_keyword'));

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
        

        if($_POST && isset($_POST['name'], $_POST['contactnumber'], $_POST['email'], $_POST['time'], $_POST['enquiry'])) {
            $data['email'] = $_POST['email'];
        }else{
            header("Location: index.php?route=information/asusform");
            die();
        }
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && true) {
			$mail = new Mail($this->config->get('config_mail_engine'));
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($this->request->post['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setReplyTo("sales@tsatech.co.nz");
			$mail->setSender('TSA Tech Limited');
			$mail->setSubject(html_entity_decode('ASUS AiMesh Experience Store Booking', ENT_QUOTES, 'UTF-8'));
            $mail->setText("Thank you for booking with TSA Tech. The booking is as the following\n".
                            "\n  Name:     ".$this->request->post['name'].
                            "\n  Time:     ".$this->request->post['time'].
                            "\n  Enquiry:  ".$this->request->post['enquiry']
                        );
            $mail->send();

            $mail2 = new Mail($this->config->get('config_mail_engine'));
			$mail2->parameter = $this->config->get('config_mail_parameter');
			$mail2->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail2->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail2->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail2->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail2->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail2->setTo('chengzhenyang@gmail.com');
            $mail2->setFrom($this->config->get('config_email'));
            $mail2->setReplyTo($this->request->post['email']);
			$mail2->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
			$mail2->setSubject(html_entity_decode('ASUS AiMesh Experience Store Booking', ENT_QUOTES, 'UTF-8'));
            $mail2->setText("A User Booked at TSA Tech. For changes pls paypal me. The booking is as the following\n".
                            "\n  Name:     ".$this->request->post['name'].
                            "\n  Phone:    ".$this->request->post['contactnumber'].
                            "\n  Email:    ".$this->request->post['email'].
                            "\n  Time:     ".$this->request->post['time'].
                            "\n  Enquiry:  ".$this->request->post['enquiry']
                        );
			$mail2->send();
        }

        $this->response->setOutput($this->load->view('information/asusformcomplete', $data));
    }
}
