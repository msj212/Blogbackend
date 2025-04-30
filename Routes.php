<?php
include "./Modules.php";
$module = new MYBLOG();
$routespath = $_GET["routes"];
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
switch ($routespath) {
    case "Home":
        echo $module->GetHomePageData();
        break;
    case "About":
        echo $module->GetAboutPageData();
        break;
    case "Service":
        echo $module->GetServicePageData();
        break;
    case "Skill":
        echo $module->GetSkillPageData();
        break;
    case "Resume":
        echo $module->GetResumePageData();
        break;
    case "Portfolio":
        echo $module->GetPortfolioPageData();
        break;
    case "Blog":
        echo $module->GetBlogPageData();
        break;
}
