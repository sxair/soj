<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProceduce extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        DELIMITER $$
//CREATE DEFINER=`root`@`localhost` PROCEDURE `oj_judge_start`(IN `in_status_id` INT UNSIGNED, OUT `out_lang` TINYINT, OUT `out_pro_id` INT UNSIGNED, OUT `out_user_id` INT UNSIGNED, OUT `out_code` TEXT, OUT `out_true_pro_id` INT UNSIGNED)
//    READS SQL DATA
//BEGIN
//	UPDATE `oj_status` SET `status`=1 WHERE id=in_status_id;
//	SELECT `problem_id`,`lang`,`user_name` INTO out_pro_id,out_lang,@user_name FROM `oj_status` WHERE `id`=in_status_id;
//    SELECT `id` INTO out_user_id FROM `users` WHERE `name`=@user_name;
//   	SELECT `problem_id` INTO out_true_pro_id FROM `oj_problems` WHERE `id`=out_pro_id;
//    SELECT `code` INTO out_code FROM oj_codes where `status_id`=in_status_id;
//END$$
//DELIMITER ;

//        DELIMITER $$
//CREATE DEFINER=`root`@`localhost` PROCEDURE `get_judges`(IN `i_id` TINYINT, IN `i_maxnum` TINYINT)
//    NO SQL
//BEGIN
//start transaction;
//SELECT status_id,judge_for FROM judges WHERE running=0 LIMIT i_maxnum FOR UPDATE;
//                                                                          UPDATE judges set running=i_id WHERE running=0 LIMIT i_maxnum;
//COMMIT;
//END$$
//DELIMITER ;

//        DELIMITER $$
//CREATE DEFINER=`root`@`localhost` PROCEDURE `oj_submit`(IN `i_problem_id` INT UNSIGNED, IN `i_lang` TINYINT, IN `i_code` TEXT, IN `i_user_name` VARCHAR(20), IN `i_user_id` INT UNSIGNED, IN `i_code_len` INT)
//    NO SQL
//BEGIN
//	INSERT INTO `oj_status`(`problem_id`,`lang`,`user_name`,`code_len`) VALUES (i_problem_id,i_lang,i_user_name,i_code_len);
//    SELECT @status_id:=LAST_INSERT_ID();
//	INSERT INTO judges(`status_id`,`judge_for`) VALUES (@status_id,0);
//    INSERT INTO oj_codes(`status_id`,`code`) VALUES (@status_id,i_code);
//    UPDATE oj_problems SET submitted=submitted+1 WHERE id=i_problem_id;
//    UPDATE user_infos SET submitted=submitted+1 WHERE id=i_user_id;
// 	INSERT INTO oj_solved_problems(`user_id`,`problem_id`) VALUES (i_user_id,i_problem_id) ON DUPLICATE KEY UPDATE `submitted`=`submitted`+1;
//END$$
//DELIMITER ;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
