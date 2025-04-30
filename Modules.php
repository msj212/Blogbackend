<?php
include "./Servies.php";
class MYBLOG
{
    private $conn;

    private $Service;

    public function __construct()
    {
        $this->conn = mysqli_connect("sdb-81.hosting.stackcp.net", "msjblog-353038378fa1", "1j3np4epe5", "msjblog-353038378fa1");

        if (mysqli_connect_errno()) {
            echo json_encode(["status" => "500", "Internal Server Error" . mysqli_connect_error()]);
            exit();
        }
        $this->Service = new Serviesblog();
    }

    public function GetHomePageData()
    {
        $homepageresult = $this->Service->Getdatabytable("hero_section");
        $result = [
            "subTitle" => $homepageresult[0]["sub_title"],
            "designation" => $homepageresult[0]["designation"],
            "imgLink" => $homepageresult[0]["img_link"],
            "title" => $homepageresult[0]["title"],
            "bgImgLink" => $homepageresult[0]["bg_img_link"],
        ];
        return json_encode(["status" => "201", "data" => $result]);
    }

    public function GetAboutPageData()
    {
        $Aboutpagedetailsresult = $this->Service->Getdatabytable("about_details");
        $Aboutpageaminresult = $this->Service->Getdatabytable("about_main");
        $aboutData = [
            "imgLink" => $Aboutpageaminresult[0]['imgLink'],
            "cvPdf" => $Aboutpageaminresult[0]['cvPdf'],
            "title" => $Aboutpageaminresult[0]['title'],
            "subtitle" => $Aboutpageaminresult[0]['subtitle'],
            "text" => $Aboutpageaminresult[0]['text'],
            "details" => []
        ];
        if (is_array($Aboutpagedetailsresult)) {
            foreach ($Aboutpagedetailsresult as $detail) {
                $aboutData['details'][] = [
                    "title" => $detail['title'],
                    "info" => $detail['info']
                ];
            }
        } else {
            return json_encode(["status" => "500", "message" => "Invalid data format"]);
        }

        return json_encode(["status" => "201", "data" => $aboutData]);
    }

    public function GetServicePageData()
    {
        $Aboutpagedetailsresult = $this->Service->Getdatabytable("services");
        return json_encode(["status" => "201", "data" => $Aboutpagedetailsresult]);
    }

    public function GetSkillPageData()
    {
        $skill_overviewpagedetailsresult = $this->Service->Getdatabytable("skill_overview");
        $skillsviewpagedetailsresult = $this->Service->Getdatabytable("skills");

        $skilloutput = [
            "title" => $skill_overviewpagedetailsresult[0]["title"] ?? "",
            "text" => $skill_overviewpagedetailsresult[0]["text"] ?? "",
            "skills" => []
        ];

        if (is_array($skillsviewpagedetailsresult)) {
            foreach ($skillsviewpagedetailsresult as $detail) {
                $skilloutput['skills'][] = [
                    "title" => $detail['skill_title'] ?? "",
                    "progress" => $detail['progress'] ?? "",
                    "effect" => $detail['effect'] ?? "",
                    "duration" => $detail['duration'] ?? "",
                    "delay" => $detail['delay'] ?? ""
                ];
            }
        } else {
            return json_encode(["status" => "500", "message" => "Invalid data format"]);
        }

        return json_encode(["status" => "201", "data" => $skilloutput]);
    }


    public function GetResumePageData()
    {
        $resume_experience_pagedetailsresult = $this->Service->Getdatabytable("experience");
        $resume_education_pagedetailsresult = $this->Service->Getdatabytable("education");

        $resumeData = [
            "experienceTitle" => "Experience",
            "experience" => [],
            "educationTitle" => "Education",
            "education" => []
        ];

        if (is_array($resume_experience_pagedetailsresult)) {
            foreach ($resume_experience_pagedetailsresult as $detail) {
                $resumeData['experience'][] = [
                    "title" => $detail['title'] ?? "",
                    "duration" => $detail['duration'] ?? "",
                    "subTitle" => $detail['subTitle'] ?? "",
                    "text" => $detail['text'] ?? ""
                ];
            }
        } else {
            return json_encode(["status" => "500", "message" => "Invalid data format"]);
        }

        if (is_array($resume_education_pagedetailsresult)) {
            foreach ($resume_education_pagedetailsresult as $detail) {
                $resumeData['education'][] = [
                    "title" => $detail['title'] ?? "",
                    "duration" => $detail['duration'] ?? "",
                    "subTitle" => $detail['subTitle'] ?? "",
                    "text" => $detail['text'] ?? ""
                ];
            }
        } else {
            return json_encode(["status" => "500", "message" => "Invalid data format"]);
        }

        return json_encode(["status" => "201", "data" => $resumeData]);
    }

    public function GetPortfolioPageData()
    {
        $portfolio_resultData = $this->Service->Getdatabytable("portfolio_items");
        return json_encode(["status" => "201", "data" => $portfolio_resultData]);
    }
    public function GetBlogPageData()
    {
        $blog_informations = $this->Service->Getdatabytable("blog_informations");
        $slider_settings = $this->Service->Getdatabytable("blog_slider_settings");
        $responsive_settings = $this->Service->Getdatabytable("blog_slider_responsive");

        $slider = !empty($slider_settings) ? $slider_settings[0] : [];

        $responsive = [];
        foreach ($responsive_settings as $r) {
            $responsive[] = [
                "breakpoint" => (int)$r['breakpoint'],
                "settings" => [
                    "slidesToShow" => (int)$r['slides_to_show'],
                    "autoplay" => (bool)$r['autoplay']
                ]
            ];
        }

        $informations = [];
        foreach ($blog_informations as $info) {
            $informations[] = [
                "imgLink" => $info['img_link'],
                "designation" => $info['designation'],
                "date" => date('d-m-Y', strtotime($info['date'])),
                "title" => $info['title'],
                "href" => $info['href']
            ];
        }

        $blogData = [
            "blogData" => [
                "useFor" => $slider['use_for'] ?? "blog",
                "sliderSetting" => [
                    "infinite" => (bool)$slider['infinite'],
                    "speed" => (int)$slider['speed'],
                    "slidesToShow" => (int)$slider['slides_to_show'],
                    "slidesToScroll" => (int)$slider['slides_to_scroll'],
                    "arrows" => (bool)$slider['arrows'],
                    "responsive" => $responsive
                ],
                "informations" => $informations
            ]
        ];

        return json_encode(["status" => "201", "data" => $blogData]);
    }

    public function Addblog()
    {
        
    }
}
