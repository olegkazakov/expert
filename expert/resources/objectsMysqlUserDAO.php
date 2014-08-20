<?php

namespace expert\resources;
use expert\user\InternalUser as InternalUser;
use expert\user\Role as Role;
use expert\user\VKUser as VKUser;
use expert\user\GPUser as GPUser;
use expert\user\FBUser as FBUser;
use expert\user\User as User;
use expert\user\SocialUser as SocialUser;
use expert\linker\VKLinker as VKLinker;
use expert\linker\FBLinker as FBLinker;
use expert\linker\GpLinker as GpLinker;
use expert\resources\QuestionDAOCSV as QuestionDAOCSV;
use expert\resources\Question as Question;
use expert\resources\ResourceDAO as ResourceDAO;
$userDAO = new MysqlUserDAO();
$questionDAO = new QuestionDAOCSV();
$question = new Question("Football", "Real - Milan. Who will won?", $userDAO->find(1));
$questionDAO->getLastResourceNumber($question);