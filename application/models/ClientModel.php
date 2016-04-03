<?php

/**
 * Model class for client(customer) information
 * @category Class
 * @package pups
 * @author Muhamad
 * @version 1.0 
 * @createddate 4th Sept 2013 
 */
class Application_Model_ClientModel {

    /**
     * Function for get project list
     * @param None
     * @return None
     */
    public function getClients($project_id, $search_key, $column_name, $page) {
        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];

        $page = $page;

        $searchCondition = '';

        if ($search_key != '') {
            $searchCondition = " AND $column_name like '%$search_key%'  ";
        }

        if ($project_id > 0) {
            $searchCondition = $searchCondition . " AND cl.project_id =  $project_id ";
        }


        $sql = "SELECT * FROM `tbl_clients`as  cl 	
		WHERE cl.`deleted` = 0 " . $searchCondition . " ORDER BY `created_datetime` DESC ";

        /*
          $sql = "SELECT cl.client_name,cl.project_id, cl.proj_client_id,cl.client_id,pr.project_name,sub_aces.ace_id,sub_prime.prime_id FROM `tbl_clients`  cl
          INNER JOIN tbl_projects AS pr ON cl.project_id = pr.project_id
          LEFT JOIN (SELECT MAX(aces_calc_id) AS ace_id,client_id FROM tbl_aces_calc GROUP BY client_id ) AS sub_aces ON sub_aces.client_id = cl.client_id
          LEFT JOIN (SELECT MAX(prime_cc_calc_id) AS prime_id,client_id FROM tbl_prime_cc_calc GROUP BY client_id ) AS sub_prime ON sub_prime.client_id = cl.client_id
          WHERE cl.`deleted` = 0" . $searchCondition . " ORDER BY `proj_client_id` DESC "; */

        $result = $DB->fetchAll($sql);

        $paginator = Zend_Paginator::factory($result);

        $totalcount = $paginator->getTotalItemCount();


        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);


        return $paginator;
    }

    /**
     * Function for get project list
     * @param None
     * @return None
     */
    public function getPrimes($project_id, $search_key, $column_name, $page) {
        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];

        $page = $page;

        $searchCondition = '';

        if ($search_key != '') {
            $searchCondition = " AND cl.$column_name like '%$search_key%'  ";
        }

        if ($project_id > 0) {
            $searchCondition = $searchCondition . " AND cl.project_id =  $project_id ";
        }


        $sql = "SELECT p.*, cl.client_name, cl.proj_client_id FROM `tbl_clients`as  cl
        INNER JOIN tbl_prime_cc_calc p ON (p.project_id = cl.project_id AND p.client_id = cl.client_id AND p.deleted = 0)  	
		WHERE cl.`deleted` = 0 " . $searchCondition . " GROUP BY cl.client_id ORDER BY `created_datetime` DESC ";

        /*
          $sql = "SELECT cl.client_name,cl.project_id, cl.proj_client_id,cl.client_id,pr.project_name,sub_aces.ace_id,sub_prime.prime_id FROM `tbl_clients`  cl
          INNER JOIN tbl_projects AS pr ON cl.project_id = pr.project_id
          LEFT JOIN (SELECT MAX(aces_calc_id) AS ace_id,client_id FROM tbl_aces_calc GROUP BY client_id ) AS sub_aces ON sub_aces.client_id = cl.client_id
          LEFT JOIN (SELECT MAX(prime_cc_calc_id) AS prime_id,client_id FROM tbl_prime_cc_calc GROUP BY client_id ) AS sub_prime ON sub_prime.client_id = cl.client_id
          WHERE cl.`deleted` = 0" . $searchCondition . " ORDER BY `proj_client_id` DESC "; */

        $result = $DB->fetchAll($sql);

        $paginator = Zend_Paginator::factory($result);

        $totalcount = $paginator->getTotalItemCount();


        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);


        return $paginator;
    }

    /**
     * Function for get project list
     * @param None
     * @return None
     */
    public function getAces($project_id, $search_key, $column_name, $page) {
        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];

        $page = $page;

        $searchCondition = '';

        if ($search_key != '') {
            $searchCondition = " AND $column_name like '%$search_key%'  ";
        }

        if ($project_id > 0) {
            $searchCondition = $searchCondition . " AND cl.project_id =  $project_id ";
        }


        $sql = "SELECT p.*, cl.client_name, cl.proj_client_id FROM `tbl_clients`as  cl
        INNER JOIN tbl_aces_calc p ON (p.project_id = cl.project_id AND p.client_id = cl.client_id AND p.deleted = 0)  	
		WHERE cl.`deleted` = 0 " . $searchCondition . " GROUP BY cl.client_id ORDER BY `created_datetime` DESC ";

        /*
          $sql = "SELECT cl.client_name,cl.project_id, cl.proj_client_id,cl.client_id,pr.project_name,sub_aces.ace_id,sub_prime.prime_id FROM `tbl_clients`  cl
          INNER JOIN tbl_projects AS pr ON cl.project_id = pr.project_id
          LEFT JOIN (SELECT MAX(aces_calc_id) AS ace_id,client_id FROM tbl_aces_calc GROUP BY client_id ) AS sub_aces ON sub_aces.client_id = cl.client_id
          LEFT JOIN (SELECT MAX(prime_cc_calc_id) AS prime_id,client_id FROM tbl_prime_cc_calc GROUP BY client_id ) AS sub_prime ON sub_prime.client_id = cl.client_id
          WHERE cl.`deleted` = 0" . $searchCondition . " ORDER BY `proj_client_id` DESC "; */

        $result = $DB->fetchAll($sql);

        $paginator = Zend_Paginator::factory($result);

        $totalcount = $paginator->getTotalItemCount();


        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);


        return $paginator;
    }

    /**
     * Function for get project list
     * @param None
     * @return None
     */
    public function getClientsForGroup($project_id, $search_key, $column_name, $page) {
        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];

        $page = $page;

        $searchCondition = '';

        if ($search_key != '') {
            $searchCondition = " AND $column_name like '%$search_key%'  ";
        }

        if ($project_id > 0) {
            $searchCondition = $searchCondition . " AND cl.project_id =  $project_id ";
        }


        $sql = "SELECT * FROM `tbl_clients`as  cl 	
		WHERE cl.`deleted` = 0 AND proj_client_id NOT IN (SELECT proj_client_id FROM tbl_clientgroups ) " . $searchCondition . " ORDER BY `created_datetime` DESC ";

        /*
          $sql = "SELECT cl.client_name,cl.project_id, cl.proj_client_id,cl.client_id,pr.project_name,sub_aces.ace_id,sub_prime.prime_id FROM `tbl_clients`  cl
          INNER JOIN tbl_projects AS pr ON cl.project_id = pr.project_id
          LEFT JOIN (SELECT MAX(aces_calc_id) AS ace_id,client_id FROM tbl_aces_calc GROUP BY client_id ) AS sub_aces ON sub_aces.client_id = cl.client_id
          LEFT JOIN (SELECT MAX(prime_cc_calc_id) AS prime_id,client_id FROM tbl_prime_cc_calc GROUP BY client_id ) AS sub_prime ON sub_prime.client_id = cl.client_id
          WHERE cl.`deleted` = 0" . $searchCondition . " ORDER BY `proj_client_id` DESC "; */

        $result = $DB->fetchAll($sql);

        $paginator = Zend_Paginator::factory($result);

        $totalcount = $paginator->getTotalItemCount();


        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);


        return $paginator;
    }

    /**
     * Function for save client details
     * @param None
     * @return None
     */
    public function saveClient($proj_client_id, $data, $importStatus = 0) {

        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];

        $DB->getProfiler()->setEnabled(true);

        if ($importStatus == 1) {
            $client_id = $data['client_id'];
            $project_id = $data['project_id'];
            $resArr = $this->checkExistingClientId($client_id, $project_id);
            $proj_client_id = $resArr[0];
        }

        if ($proj_client_id > 0) {
            $result = $DB->update('tbl_clients', $data, " proj_client_id = $proj_client_id");
            $id = $proj_client_id;
            $status = 'update';
        } else {
            $result = $DB->insert('tbl_clients', $data);
            $id = $DB->lastInsertId();
            $status = 'new';
        }

        return array('id' => $id, 'status' => $status);
    }

    /**
     * Function for get project details of given project id
     * @param None
     * @return None
     */
    public function getProjectClientId($clientId) {
        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];

        $sql = " SELECT proj_client_id FROM `tbl_clients` WHERE `deleted` = 0 AND client_id = $clientId limit 1 ";

        $result = $DB->fetchCol($sql);
        return $result;
    }

    /**
     * Function for get project details of given project id
     * @param None
     * @return None
     */
    public function checkExistingClientId($clientId, $projectId) {
        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];

        $sql = " SELECT proj_client_id FROM `tbl_clients` WHERE `deleted` = 0 AND client_id = $clientId and project_id = $projectId  limit 1 ";
        $result = $DB->fetchCol($sql);
        return $result;
    }

    /**
     * Function for get project details of given project id
     * @param None
     * @return None
     */
    public function runPupProcess($proj_clientId) {
        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];

        $clientDetails = $this->getClientDetail($proj_clientId);

        $clientName = $clientDetails[$proj_clientId]['client_name'];
        $clientId = $clientDetails[$proj_clientId]['client_id'];
        $projectId = $clientDetails[$proj_clientId]['project_id'];


        if ($projectId > 0 AND $clientId > 0) {
            $data = array('deleted' => 1);
            $DB->update('tbl_prime_cc_calc', $data, " project_id = $projectId AND client_id =  '$clientId' ");
        }


        $status = $this->checkValidityPupProcess($projectId);

        if ($status != "valid") {
            return $status;
        }

        $acesEs1 = $clientDetails[$proj_clientId]['aces_es1'];
        $acesEs2 = $clientDetails[$proj_clientId]['aces_es2'];
        $acesEs3 = $clientDetails[$proj_clientId]['aces_es3'];
        $acesEsf = $clientDetails[$proj_clientId]['aces_esf'];

        if (($acesEs1 > 0) || ($acesEs2 > 0) || ($acesEs3 > 0) || ($acesEsf > 0)) {
            return 'notprime';
        }

        //P3
        $largeBalanceAccount = $clientDetails[$proj_clientId]['large_balance'];
        //P4 
        $mediumBalanceAccount = $clientDetails[$proj_clientId]['medium_balance'];
        //P5
        $smallBalanceAccount = $clientDetails[$proj_clientId]['small_balance'];
        //P6
        $controlledCostAccounts = $clientDetails[$proj_clientId]['controlled_cost_accounts'];

        //p7. Total Dollar Volume = LIST AMT
        $totalDollarVolume = $clientDetails[$proj_clientId]['list_amount'];

        //p9. Legal Dollars Recovered = TOTAL LEGAL AMOUNT EARNED
        $legalDollarsRecovered = $clientDetails[$proj_clientId]['legal_total_amount_earned'];

        //P9.2. Total Dollars Recovered = PAID AMT - (Court Costs & Attorney Fees)
        $paidAmount = $clientDetails[$proj_clientId]['paid_amount'];
        $courtCostFee = $clientDetails[$proj_clientId]['court_cost_fee'];
        $attorneyFee = $clientDetails[$proj_clientId]['attorney_fee'];
        //	P13. 
        $ccAndAttorneyFee = ($courtCostFee + $attorneyFee);
        $totalDollarsRecovered = ($paidAmount - $ccAndAttorneyFee);

        //p8. Non Legal Dollars Recovered = Total Dollars Recovered {P9-12} – Legal Dollars Recovered {P9}
        $nonLegalDollarsRecovered = ($totalDollarsRecovered - $legalDollarsRecovered);

        //p9.3 
        $averageAgeofAccount = $clientDetails[$proj_clientId]['average_age_acc'];

        // Total # of Accounts {P3-6}
        $totalNoOfAccounts = ($largeBalanceAccount + $mediumBalanceAccount + $smallBalanceAccount + $controlledCostAccounts);

        //P9-4. Total Dollar Volume Placed {P7} / Total # of Accounts {P3-6}
        $averageBalance = ($totalDollarVolume / $totalNoOfAccounts );

        //12. 
        $totalFees = $clientDetails[$proj_clientId]['earned_amount'];

        //12-2
        //Total Fees {P12} – CC & ATTNY Fees {P13}
        $nonLegalFees = ($totalFees - $ccAndAttorneyFee);

        //P10. Non-legal Fees {P12-2} / Total Dollars Recovered {P9-2}
        $feeRate = ($nonLegalFees / $totalDollarsRecovered);

        //P11. Total Dollars Recovered {P9-2} / Total Dollars Volume {P7}
        $recoveryRate = ($totalDollarsRecovered / $totalDollarVolume);

        //P14. # of Accounts Total {P3-6} /Non-legal Fees {P12-2}
        $averageFeePerAccount = ($nonLegalFees / $totalNoOfAccounts );

        //DIRECT COST

        $projectId = $clientDetails[$proj_clientId]['project_id'];

        $configModelObject = new Application_Model_ConfigModel();
        $configDetails = $configModelObject->getConfigDetails($projectId);
        /* print_r($clientDetails);
          exit; */

        $laborCostPrimePerCustomer = ($configDetails[$projectId][prime_labor_cost] / $configDetails[$projectId][prime_account_no]);

        // 15. Large Balance Accounts {P3} * Labor Cost Per (config)
        $laborCostsForCollectorsPrime = ($largeBalanceAccount * $laborCostPrimePerCustomer);


        $smallMedCCAccounts = ($mediumBalanceAccount + $controlledCostAccounts );
        //$totalDollarsRecovered  = $clientDetails[$proj_clientId]['list_amount']; 
        //16. Small, Med, CC Accounts {P4-6}* Labor Cost Per (config)
        $ccMedLaborCostPerCustomer = ($configDetails[$projectId][cc_med_labor_cost] / $configDetails[$projectId][controlled_cost_no]);

        $laborCostsForCollectorsControlledCost_Med = ($smallMedCCAccounts * $ccMedLaborCostPerCustomer);

        //17. Total Labor Costs = Labor Cost Prime  {P15} + Labor Cost for CC  & Med {P16}
        $totalLaborCosts = ($laborCostsForCollectorsPrime + $laborCostsForCollectorsControlledCost_Med);

        //18. BenefitsCostPrime = Large Balance Accounts {P3} * Benefit Cost Per (config)
        $primeBenefitCostPerCustomer = ($configDetails[$projectId][prime_benefit_cost] / $configDetails[$projectId][prime_account_no] );
        $benefitsCostPrime = ($largeBalanceAccount * $primeBenefitCostPerCustomer);

        //19. Benefits Cost (CC & MED) = Small, Med, CC Accounts {P4-6} * Benefit Cost Per (config)

        $ccBenefitCostPerCustomer = ($configDetails[$projectId][cc_med_benefit_cost] / $configDetails[$projectId][controlled_cost_no]);
        $benefitCostCCMed = ($smallMedCCAccounts * $ccBenefitCostPerCustomer);

        //20. Total Benefits Cost = Benefits Cost Prime {P18} + Benefits Cost CC & Med {P19}
        $totalBenefitCost = ($benefitsCostPrime + $benefitCostCCMed);

        //21. Statement Cost (Prime) = Total no of accounts * Statement Cost Prime (config) per customer
        //$statementCostPrime_Config = $configDetails[$projectId][prime_statement_cost];  
        $statementCostPrimePerCustomer = ($configDetails[$projectId][prime_statement_cost] / $configDetails[$projectId][prime_account_no]);
        $statementCostPrime = ($largeBalanceAccount * $statementCostPrimePerCustomer);

        //22 . Statement Cost (CC & MED) = Small, Med, CC Accounts {P4-6}* Statement Cost Med (config) 
        $statementCostCCMedPerCustomer = ($configDetails[$projectId][sm_med_cont_aces_stmnt_cost] / $configDetails[$projectId][controlled_cost_no]);
        $statementCostCCMed = ($statementCostCCMedPerCustomer * $smallMedCCAccounts);

        //23. Total Statement Cost = Statement Cost Prime {P21} + Statement Cost CC & Med {P22}
        $totalStatementCost = ($statementCostPrime + $statementCostCCMed );

        //24. Sales Bonus = Sales Bonus Percentages (Config) * Total Fees {P12}
        $salesBonus = $clientDetails[$proj_clientId]['sales_comm_percentage'] * $nonLegalFees / 100;

        //25. Small Balance Accounts Costs = # Small Balance Accounts {P5} * Small Balance Account Cost (config)
        $smallBalanceAccountCost_Config = $configDetails[$projectId][small_bal_acc_cost];
        $smallBalanceAccountCost = ($smallBalanceAccount * $smallBalanceAccountCost_Config);

        //26.  Other Direct Costs – PRIME = Other Direct Costs per customer prime (config) * # Large Balance Accounts {P3}
        $primeOtherDirectCostPerCustomer = ($configDetails[$projectId][prime_other_direct_cost] / $configDetails[$projectId][prime_account_no]);
        $otherDirectCostPrime = ($primeOtherDirectCostPerCustomer * $largeBalanceAccount);


        //27. Other Direct Costs – (CC & Med) = Other Direct Costs per customer CC (config) * # of Small, Med, CC Accounts {P4-6)
        $ccOtherDirectCostPerCustomer = ($configDetails[$projectId][cc_other_direct_cost] / $configDetails[$projectId][controlled_cost_no]);
        $otherDirectCostCcMed = ($ccOtherDirectCostPerCustomer * $smallMedCCAccounts);

        //28. Other Direct Costs Total = Other Direct Costs Prime {P26} + Other Direct Costs CC & Med {P27}
        $totalOtherDirectCost = ($otherDirectCostPrime + $otherDirectCostCcMed);

        //29. Total Direct Costs = SUM All Direct Cost Fields {P17+P20+P23+P24+P25+P28}
        $totalDirectCost = ($totalLaborCosts + $totalBenefitCost + $totalStatementCost + $salesBonus + $smallBalanceAccountCost + $totalOtherDirectCost);

        // 30. 
        $clientLegalAmountEarnedUs = $clientDetails[$proj_clientId]['legal_fee_amount_earned_us'];

        //31
        $totalLegalAmountEarned = $configDetails[$projectId][total_legal_earned];

        //32 
        $legalExpenses = $configDetails[$projectId][total_legal_expense];

        // 33. Legal Expense – Customer = Client Legal Expense Earned Us {P30} / (Total Legal Amount Earned Us  {P31}* Total Legal Expense (config)

        $legalExpenseCustomer = $clientLegalAmountEarnedUs / $totalLegalAmountEarned * $legalExpenses;

        // 34. 
        $noOfActiveCustomers = $configDetails[$projectId][active_client_no];

        //35. Average Cost Per Account = Total Direct Costs {P29}/ Total Number of Accounts (config)
        $averageCostPerAccount = ($totalDirectCost / $noOfActiveCustomers );

        //36. Total Cost of Collection = Total Direct Costs {P29}+ Legal Expenses {P32}
        $totalCostOfCollection = ($totalDirectCost + $legalExpenseCustomer);

        //37. Total Profit/Loss = Total Fees {P12}– Total Cost of Collection {P36}
        $totalProfitLoss = ($totalFees - $totalCostOfCollection);

        //38. 
        $indirectCost = $configDetails[$projectId][indirect_cost];

        //39.Indirect Costs (per customer) = Customer Total Fee Income {P12}/Total fee income for Company {C25} * By Total Indirect Costs for Company {C17}
        $customerTotalFeeIncome = $totalFees;
        //C25 - Total Fee Income for the Year
        $totalFeeIncomeForCompany = $configDetails[$projectId][total_fee_income_for_the_year];

        //C17 - Indirect Costs
        $denominator1 = ($totalFeeIncomeForCompany * $indirectCost);
        $inderectCostPerCustomer = $totalFees / $totalFeeIncomeForCompany * $indirectCost;
        //36. Total Cost of Collection
        $totalCostOfCollection += $inderectCostPerCustomer;
        //40. Total Profit/Loss Including Indirect = Total Fees {P12-2} – Total Cost of Collection {P36} – Indirect Costs per Customer {P39}
        $totalProfitLossInclindirect = $totalFees - $totalCostOfCollection;

        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
        $userid = $user->user_id;

        $created_datetime = date("Y-m-d h:i:s");

        $data = array(
            'client_id' => "$clientId",
            'project_id' => $projectId,
            'large_bal_account_p3' => $largeBalanceAccount,
            'medium_bal_account_p4' => $mediumBalanceAccount,
            'small_bal_account_p5' => $smallBalanceAccount,
            'controlled_cost_account_p6' => $controlledCostAccounts,
            'total_dollar_volume_p7' => $totalDollarVolume,
            'non_legal_dollars_recovered_p8' => $nonLegalDollarsRecovered,
            'legal_dollars_recovered_p9' => $legalDollarsRecovered,
            'total_dollars_recovered_p9_2' => $totalDollarsRecovered,
            'avg_age_of_account_p9_3' => $averageAgeofAccount,
            'avg_balance_p9_4' => round($averageBalance),
            'fee_rate_p10' => round($feeRate, 2),
            'recovery_rate_p11' => round($recoveryRate, 3),
            'total_fees_p12' => $totalFees,
            'nonlegal_fees_p12_2' => round($nonLegalFees, 2),
            'cc_attorney_fees_p13' => round($ccAndAttorneyFee, 2),
            'avg_fee_per_account_p14' => round($averageFeePerAccount, 2),
            'labot_cost_for_collectors_prime_p15' => round($laborCostsForCollectorsPrime, 2),
            'labot_cost_for_collectors_contr_p16' => round($laborCostsForCollectorsControlledCost_Med, 2),
            'total_labor_cost_p17' => round($totalLaborCosts, 2),
            'benefit_cost_prime_p18' => round($benefitsCostPrime, 2),
            'benefit_cost_ccmed_p19' => round($benefitCostCCMed, 2),
            'total_benefit_cost_p20' => round($totalBenefitCost, 2),
            'statement_cost_prime_p21' => round($statementCostPrime, 2),
            'statement_cost_ccmed_p22' => round($statementCostCCMed, 2),
            'total_statement_cost_p23' => round($totalStatementCost, 2),
            'sales_bonus_P24' => round($salesBonus, 2),
            'small_balance_acc_cost_p25' => round($smallBalanceAccountCost, 2),
            'other_direct_cost_prime_p26' => round($otherDirectCostPrime, 2),
            'other_direct_cost_ccmed_p27' => round($otherDirectCostCcMed, 2),
            'other_direct_cost_total_p28' => round($totalOtherDirectCost, 2),
            'total_direct_cost_p29' => round($totalDirectCost, 2),
            'client_legal_amount_earned_us_p30' => round($clientLegalAmountEarnedUs, 2),
            'total_legal_amount_earned_p31' => $totalLegalAmountEarned,
            'legal_expenses_p32' => round($legalExpenses, 2),
            'legal_expenses_customer_p33' => $legalExpenseCustomer,
            'number_of_active_customers_p34' => round($noOfActiveCustomers, 2),
            'avg_cost_per_acc_p35' => round($averageCostPerAccount, 2),
            'total_cost_of_collections_p36' => round($totalCostOfCollection, 2),
            'total_profit_loss_p37' => round($totalProfitLoss, 2),
            'indirect_cost_company_p38' => round($indirectCost, 2),
            'indirect_cost_per_customer_p39' => round($inderectCostPerCustomer, 2),
            'total_profit_loss_incl_indirect_p40' => round($totalProfitLossInclindirect, 2),
            'created_by' => $userid,
            'creation_datetime' => $created_datetime
        );

        $this->savePrimeCcCalc($data);
        $status = 'success';
        return $status;

        // $sql = "SELECT project_id,project_name FROM `tbl_projects` WHERE `deleted` = 0 AND project_id = $projectId ";
        //$result = $DB->fetchAssoc($sql);
        //return $result;
    }

    public function getPupCalcDetails($clientId) {

        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];

        $sql = "SELECT client_id,large_bal_account_p3,medium_bal_account_p4,small_bal_account_p5,controlled_cost_account_p6,total_dollar_volume_p7,non_legal_dollars_recovered_p8,
		 legal_dollars_recovered_p9,total_dollars_recovered_p9_2,avg_age_of_account_p9_3,avg_balance_p9_4,fee_rate_p10,recovery_rate_p11,total_fees_p12,nonlegal_fees_p12_2,
		 cc_attorney_fees_p13,avg_fee_per_account_p14,labot_cost_for_collectors_prime_p15,labot_cost_for_collectors_contr_p16,total_labor_cost_p17,benefit_cost_prime_p18,
		 benefit_cost_ccmed_p19,total_benefit_cost_p20,statement_cost_prime_p21,statement_cost_ccmed_p22,total_statement_cost_p23,sales_bonus_P24,small_balance_acc_cost_p25,
		 other_direct_cost_prime_p26,other_direct_cost_ccmed_p27,other_direct_cost_total_p28,total_direct_cost_p29,client_legal_amount_earned_us_p30,total_legal_amount_earned_p31,
		 legal_expenses_p32,legal_expenses_customer_p33,number_of_active_customers_p34,avg_cost_per_acc_p35,total_cost_of_collections_p36,total_profit_loss_p37,indirect_cost_company_p38,
		 indirect_cost_per_customer_p39,total_profit_loss_incl_indirect_p40,created_by,creation_datetime FROM tbl_prime_cc_calc WHERE  client_id  = $clientId AND deleted = 0 order by prime_cc_calc_id desc limit 1 ";

        $result = $DB->fetchAssoc($sql);

        return $result;
    }

    /**
     * Function for get project details of given project id
     * @param None
     * @return None
     */
    public function getProjectDetails($projectId) {
        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];
        $sql = "SELECT project_id,project_name FROM `tbl_projects` WHERE `deleted` = 0 AND project_id = $projectId ";
        $result = $DB->fetchAssoc($sql);
        return $result;
    }

    public function getClientDetail($Id) {

        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];

        $sql = "SELECT proj_client_id,client_name,client_id,pr. project_id,client_id_group,client_name,`status`,pr.project_name,
			sales_rep_id,list_amount,paid_amount,earned_amount,age,cl.small_balance,cl.medium_balance,cl.large_balance,cl.legal_fee_amount,cl.controlled_cost_accounts,
			cl.average_age_acc,cl.paid_amount,cl.court_cost_fee,cl.attorney_fee,cl.collection_fee,cl.legal_total_amount_earned,cl.legal_fee_amount_earned_us,cl.principal_paid,
			cl.total_paid,cl.legal_fee_amount_earned_client,cl.aces_es1,cl.aces_es2,cl.aces_es3,cl.aces_esf,cl.aces_paid_amount,cl.aces_list_amount,cl.average_age_acc, 
			if(sc.sales_comm_percentage,sc.sales_comm_percentage,0) as sales_comm_percentage   
			FROM `tbl_clients`  cl 
			INNER JOIN tbl_projects AS pr on cl.project_id = pr.project_id 
			LEFT JOIN tbl_sales_commission AS sc on sc.sales_id = cl.sales_rep_id  
			WHERE cl.`deleted` = 0 AND proj_client_id  = $Id ";

        $result = $DB->fetchAssoc($sql);
        return $result;
    }

    /**
     * Function for get project details of given project id
     * @param None
     * @return None
     */
    public function runAcesProcess($proj_clientId) {
        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];

        $clientDetails = $this->getClientDetail($proj_clientId);

        $clientName = $clientDetails[$proj_clientId]['client_name'];
        $clientId = $clientDetails[$proj_clientId]['client_id'];
        $projectId = $clientDetails[$proj_clientId]['project_id'];



        if ($projectId > 0 AND $clientId > 0) {
            $data = array('deleted' => 1);
            $DB->update('tbl_aces_calc', $data, " project_id = $projectId AND client_id =  '$clientId' ");
        }

        $status = $this->checkValidityAcesProcess($projectId);
        if ($status != "valid") {
            return $status;
        }



        $acesEs1 = $clientDetails[$proj_clientId]['aces_es1'];
        $acesEs2 = $clientDetails[$proj_clientId]['aces_es2'];
        $acesEs3 = $clientDetails[$proj_clientId]['aces_es3'];
        $acesEsf = $clientDetails[$proj_clientId]['aces_esf'];

        if ($acesEs1 == 0 && $acesEs2 == 0 && $acesEs3 == 0 && $acesEsf == 0) {
            return 'notace';
        }



        //a8. Total Dollar Volume Recovered = Paid Amount (Pups CSV) 
        $acesPaidAmount = $clientDetails[$proj_clientId]['aces_paid_amount'];
        //a7. Total Dollar Volume = List Amount (Pups CSV)
        $totalDollarVolume = $clientDetails[$proj_clientId]['aces_list_amount'];
        //a9
        $avgAgeOfAccount = $clientDetails[$proj_clientId]['average_age_acc'];

        //a10. SUM (ES1*5, ES2*10, ES3*15)
        $feeAmount = ( ($acesEs1 * 5) + ($acesEs2 * 10) + ($acesEs3 * 15) );

        $miscFee = $clientDetails[$proj_clientId]['earned_amount'];
        //12. Total Fees (PL Balance) = Total Fee Amount {A10} + Misc Fee {A12}
        $totalFees = ($feeAmount + $miscFee);

        //DIRECT COSTS
        //13. Labor Costs = Add {A3-A6} * Labor Cost Per Account {config}
        $a3ToA6 = ($acesEs1 + $acesEs2 + $acesEs3 + $acesEsf);

        //A13.  $laborCosts = $a3MinusA6 * ; 
        $configModelObject = new Application_Model_ConfigModel();
        $configDetails = $configModelObject->getConfigDetails($projectId);
        $laborCostPrimePerCustomer = ($configDetails[$projectId][aces_labor_cost] / $configDetails[$projectId][aces_total_acc_no]);

        $laborCosts = ( $a3ToA6 * $laborCostPrimePerCustomer);

        //14. Benefits Cost  = Add {A3-A6} * Benefit Cost Per Account {config};
        $acesBenefitCostPerCustomer = ($configDetails[$projectId][aces_benefit_cost] / $configDetails[$projectId][aces_total_acc_no]);
        $benefitCost = ($a3ToA6 * $acesBenefitCostPerCustomer);

        //15. Statement Cost {config}* All Accounts - Add {A3-A6}
        $aces_statement_cost_per_customer = ( $configDetails[$projectId][aces_statement_cost] / $configDetails[$projectId][aces_total_acc_no] );
        $statementCost = ($a3ToA6 * $aces_statement_cost_per_customer);

        //16. sales Bonus = Sales Bonus (Config) * Fee Amount {A10}
        //$salesBonusConfig = $configDetails[$projectId][aces_sales_bonus_id];
        $salesBonus = $clientDetails[$proj_clientId]['sales_comm_percentage'] * $feeAmount / 100;

        //17.  Other Direct Costs  = Other Direct Costs per customer (config)* # ACES Accounts {A3-6}
        $acessOtherDirectCostPerCustomer = ($configDetails[$projectId][aces_other_direct_cost] / $configDetails[$projectId][aces_total_acc_no]);
        $otherDirectCost = ($a3ToA6 * $acessOtherDirectCostPerCustomer);

        //18. Total Direct Costs = SUM All Direct Cost Fields {A13-17} 
        $totalDirectCost = ($laborCosts + $benefitCost + $statementCost + $salesBonus + $otherDirectCost);

        //19
        $totalActiveCustomers = $configDetails[$projectId][active_client_no];

        //20. Average Cost Per Account = Total Direct Costs {A18} / All ACES Accounts {A3-6}
        $averageCostPerAccount = ($totalDirectCost / $a3ToA6);



        //22. Indirect Costs Company = from config table
        $indirectCostsCompany = $configDetails[$projectId][aces_indirect_cost];

        //23. Indirect Costs Per Customer  = Customer Total Fee Income {A12}/Total fee income for Company {config} * By Total Indirect Costs for Company {config} 
        $totalFeeIncomeForTheCompany = $configDetails[$projectId][aces_total_com_fee_collected];
        $indirectCostPerCustomer = ($totalFees / $totalFeeIncomeForTheCompany) * $indirectCostsCompany;

        //21.1 Total Cost of Collection = Total Direct Costs {A18} + Indirect Costs Per Customer {A23}
        $totalCostOfCollection = ($totalDirectCost + $indirectCostPerCustomer);

        //21 Total Profit/Loss = Total Fees {A12} –Total Direct Costs {A18}
        $totalProfitLoss = ($totalFees - $totalCostOfCollection);

        //24. Total Profit/Loss with Indirect = Total Fees {A12} –Total Direct Costs {A18} – Indirect Costs Per Customer {A23}
        $totalProfitLostWithIndirect = ($totalFees - $totalDirectCost - $indirectCostPerCustomer);

        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
        $userid = $user->user_id;

        $created_datetime = date("Y-m-d h:i:s");

        $data = array(
            'client_id' => "$clientId",
            'project_id' => $projectId,
            'es1_a3' => $acesEs1,
            'es2_a4' => $acesEs2,
            'es3_a5' => $acesEs3,
            'esf_a6' => $acesEsf,
            'total_dollar_vol_a7' => $totalDollarVolume,
            'total_dollar_vol_recovered_a8' => $acesPaidAmount,
            'avg_age_account_a9' => $avgAgeOfAccount,
            'fee_amount_a10' => $feeAmount,
            'misc_fee_a11' => $miscFee,
            'total_fees_a12' => $totalFees,
            'labor_cost_a13' => $laborCosts,
            'benefit_cost_a14' => $benefitCost,
            'statement_cost_a15' => $statementCost,
            'sales_bonus_a16' => $salesBonus,
            'other_direct_cost_a17' => $otherDirectCost,
            'total_direct_cost_a18' => $totalDirectCost,
            'total_number_active_customers_a19' => $totalActiveCustomers,
            'avg_cost_per_account_a20' => round($averageCostPerAccount, 2),
            'total_cost_collection_a20_1' => $totalCostOfCollection,
            'total_profit_lost_a21' => $totalProfitLoss,
            'indirect_cost_company_a22' => $indirectCostsCompany,
            'indirect_cost_per_company_a23' => $indirectCostPerCustomer,
            'total_profit_loss_indirect_a24' => $totalProfitLostWithIndirect,
            'created_by' => $userid,
            'creation_datetime' => $created_datetime
        );


        $this->saveAcesCalc($data);


        $status = 'success';

        return $status;
    }

    public function saveAcesCalc($data) {

        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];
        $result = $DB->insert('tbl_aces_calc', $data);
    }

    public function savePrimeCcCalc($data) {

        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];
        $result = $DB->insert('tbl_prime_cc_calc', $data);
    }

    public function checkValidityPupProcess($projectId) {

        $configModelObject = new Application_Model_ConfigModel();
        $configData = $configModelObject->getConfigId($projectId);
        $configId = $configData[0];

        if ($configId <= 0) {
            return "invalid";
        }

        return 'valid';
    }

    public function checkValidityAcesProcess($projectId) {


        $configModelObject = new Application_Model_ConfigModel();
        $configData = $configModelObject->getConfigId($projectId);
        $configId = $configData[0];

        if ($configId <= 0) {
            return "invalid";
        }

        return 'valid';
    }

    public function getAcesCalcDetails($clientId) {

        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];

        $sql = "SELECT client_id, es1_a3, es2_a4, es3_a5, esf_a6,total_dollar_vol_a7,total_dollar_vol_recovered_a8,
		avg_age_account_a9,fee_amount_a10,misc_fee_a11,total_fees_a12,labor_cost_a13,benefit_cost_a14,statement_cost_a15,
		sales_bonus_a16,other_direct_cost_a17,total_direct_cost_a18,total_number_active_customers_a19,avg_cost_per_account_a20,
		total_cost_collection_a20_1,total_profit_lost_a21,indirect_cost_company_a22,indirect_cost_per_company_a23,total_profit_loss_indirect_a24,
		created_by,creation_datetime FROM tbl_aces_calc WHERE  client_id  = $clientId  AND deleted = 0 order by aces_calc_id desc limit 1  ";

        $result = $DB->fetchAssoc($sql);

        return $result;
    }

    public function getAcesCalcStatus($clientId) {

        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];

        $sql = "SELECT count(client_id) as cnt WHERE  client_id  = $clientId ";

        $result = $DB->fetchAssoc($sql);

        return $result;
    }

    /**
     * Function for delete project details
     * @param None
     * @return None
     */
    public function deleteClient($projectCleintId) {
        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];

        if ($projectCleintId > 0) {
            $data = array('deleted' => 1);
            $DB->update('tbl_clients', $data, " proj_client_id = $projectCleintId ");
        }

        return $result;
    }

    function saveClientPrimeReport($proj_clientId) {

        //$clientModelObject = new Application_Model_ClientModel(); 

        $data = $this->getClientDetail("$proj_clientId");

        $clientName = $data[$proj_clientId]['client_name'];
        $clientId = $data[$proj_clientId]['client_id'];
        $projectId = $data[$proj_clientId]['project_id'];
        $groupId = $data[$proj_clientId]['client_id_group'];

        $aces_es1 = $data[$proj_clientId]['aces_es1'];
        $aces_es2 = $data[$proj_clientId]['aces_es2'];
        $aces_es3 = $data[$proj_clientId]['aces_es3'];
        $aces_esf = $data[$proj_clientId]['aces_esf'];

        if (($aces_es1 > 0) || ($aces_es2 > 0) || ($aces_es3 > 0) || ($aces_esf > 0)) {
            return false;
        }


        $fileName = $clientId . '.pdf';

        $folderPath1 = "public/report/project_prime_" . $projectId;

        if (!is_dir($folderPath1)) {
            mkdir($folderPath1, 0777);
        }

        $folderPath = "public/report/project_prime_" . $projectId . "/" . $clientId;

        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777);
        }

        $fullPath = "public/report/project_prime_" . $projectId . "/" . $clientId . "/" . $fileName;

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        $prime_calc_details = $this->getPupCalcDetails($clientId);
        $prime_calc_details[$clientId]['avg_age_of_account_p9_3'] = $data[$proj_clientId]['age'];

        $projectArr = $this->getProjectDetails($projectId);
        $projectName = $projectArr[$projectId]['project_name'];


        $pdf = new Zend_Pdf();
        $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER_BOLD_ITALIC);


        // Draw rectangle 
        $page->setFillColor(new Zend_Pdf_Color_Html('#00661A'));
        $page->setLineColor(new Zend_Pdf_Color_Html('#FFFFFF'));
        //$page->setLineDashingPattern(array(3, 2, 3, 4), 1.6); 
        $page->drawRectangle(20, 760, 580, 800);

        $page->setFillColor(new Zend_Pdf_Color_Html('#FFFFFF'));

        $page->setFont($font, 18)->drawText("PRIME/CC CUSTOMER PUP REPORT", 160, 775);

        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);

        $page->setFillColor(new Zend_Pdf_Color_Html('#000000'));

        $page->setFont($font, 10)->drawText("Client Name : $clientName ", 25, 745);

        ($groupId != '') ? $page->setFont($font, 10)->drawText("Group Id : $groupId ", 25, 730) : '';

        $page->setFont($font, 10)->drawText("Client Id : $clientId ", 25, 715);
        $today = date('Y-m-d');
        $page->drawText("Date : $today ", 470, 710);
        $page->drawText("Performance Evaluation : $projectName ", 25, 700);

        $page->setLineColor(new Zend_Pdf_Color_Html('#8b8b8a'));

        $page->drawLine(25, 680, 580, 680);

        $page->setLineColor(new Zend_Pdf_Color_Html('#8b8b8a'));

        $page->drawText("TOTAL", 300, 660);

        $page->drawLine(300, 655, 330, 655);

        $page->drawText("LB Accts submitted ($100+)", 30, 640);
        $large_bal_account_p3 = intval($prime_calc_details[$clientId]['large_bal_account_p3']);
        $page->drawText("$large_bal_account_p3", 300, 640);

        $page->drawText("MED Accts submitted ($25-$99.99)", 30, 625);
        $medium_bal_account_p4 = intval($prime_calc_details[$clientId]['medium_bal_account_p4']);
        $page->drawText("$medium_bal_account_p4", 300, 625);

        $page->drawText("SB Accts submitted (under $25)", 30, 610);
        $small_bal_account_p5 = intval($prime_calc_details[$clientId]['small_bal_account_p5']);
        $page->drawText("$small_bal_account_p5", 300, 610);

        $page->drawText("Control Cost Accts submitted)", 30, 595);
        $controlled_cost_account_p6 = intval($prime_calc_details[$clientId]['controlled_cost_account_p6']);
        $page->drawText("$controlled_cost_account_p6", 300, 595);

        $page->drawText("Total dollar volume placed (sql or pa)", 30, 580);
        $total_dollar_volume_p7 = '$' . number_format($prime_calc_details[$clientId]['total_dollar_volume_p7'], 2);
        $page->drawText("$total_dollar_volume_p7", 300, 580);

        $page->drawText("Non Legal dollars recovered", 30, 565);
        $non_legal_dollars_recovered_p8 = '$' . number_format($prime_calc_details[$clientId]['non_legal_dollars_recovered_p8'], 2);
        $page->drawText("$non_legal_dollars_recovered_p8", 300, 565);

        $page->drawText("Legal dollars recovered", 30, 550);
        $legal_dollars_recovered_p9 = '$' . number_format($prime_calc_details[$clientId]['legal_dollars_recovered_p9'], 2);
        $page->drawText("$legal_dollars_recovered_p9", 300, 550);

        $page->drawText("Total dollars recovered", 30, 535);
        $total_dollars_recovered_p9_2 = '$' . number_format($prime_calc_details[$clientId]['total_dollars_recovered_p9_2'], 2);
        $page->drawText("$total_dollars_recovered_p9_2", 300, 535);

        $page->drawText("Average age of account", 30, 520);
        $avg_age_of_account_p9_3 = intval($prime_calc_details[$clientId]['avg_age_of_account_p9_3']);
        $page->drawText("$avg_age_of_account_p9_3", 300, 520);

        $page->drawText("Average Balance", 30, 505);
        $avg_balance_p9_4 = '$' . number_format($prime_calc_details[$clientId]['avg_balance_p9_4'], 2);
        $page->drawText("$avg_balance_p9_4", 300, 505);

        $page->setLineColor(new Zend_Pdf_Color_Html('#7ac143'));
        $page->drawLine(25, 490, 580, 490);

        $page->drawText("Recovery rate", 30, 475);
        $recovery_rate_p11 = $prime_calc_details[$clientId]['recovery_rate_p11'] * 100;
        $page->drawText("$recovery_rate_p11%", 300, 475);

        $page->drawText("Fee at", 30, 460);
        $fee_rate_p10 = $prime_calc_details[$clientId]['fee_rate_p10'];
        $page->drawText("$fee_rate_p10", 300, 460);

        $page->drawText("Non-legal Fees", 350, 460);
        $nonlegal_fees_p12_2 = '$' . number_format($prime_calc_details[$clientId]['nonlegal_fees_p12_2'], 2);
        $page->drawText("$nonlegal_fees_p12_2", 530, 460);

        $page->drawText("Legal Fees", 350, 445);

        $page->drawText("CC & ATTY Fees", 350, 430);
        $cc_attorney_fees_p13 = '$' . number_format($prime_calc_details[$clientId]['cc_attorney_fees_p13'], 2);
        $page->drawText("$cc_attorney_fees_p13", 530, 430);

        $page->drawText("TOTAL", 350, 415);
        $total_fees_p12 = '$' . number_format($prime_calc_details[$clientId]['total_fees_p12'], 2);
        $page->drawText("$total_fees_p12", 530, 415);

        $page->drawText("Average fee per account", 30, 415);
        $avg_fee_per_account_p14 = $prime_calc_details[$clientId]['avg_fee_per_account_p14'];
        $page->drawText("$avg_fee_per_account_p14", 300, 415);

        $page->drawText("DIRECT COSTS", 30, 385);
        $page->drawText("CC", 300, 385);
        $page->drawText("PRIME", 350, 385);
        $page->drawLine(25, 380, 580, 380);

        $page->drawText("Labor cost for collectors", 30, 365);


        $labot_cost_for_collectors_contr_p16 = '$' . number_format($prime_calc_details[$clientId]['labot_cost_for_collectors_contr_p16'], 2);
        $page->drawText("$labot_cost_for_collectors_contr_p16", 300, 365);

        $labot_cost_for_collectors_prime_p15 = '$' . number_format($prime_calc_details[$clientId]['labot_cost_for_collectors_prime_p15'], 2);
        $page->drawText("$labot_cost_for_collectors_prime_p15", 350, 365);


        $total_labor_cost_p17 = '$' . number_format($prime_calc_details[$clientId]['total_labor_cost_p17'], 2);
        $page->drawText("$total_labor_cost_p17", 530, 365);

        $page->drawText("Benefit costs", 30, 350);

        $benefit_cost_ccmed_p19 = '$' . number_format($prime_calc_details[$clientId]['benefit_cost_ccmed_p19'], 2);
        $page->drawText("$benefit_cost_ccmed_p19", 300, 350);

        $benefit_cost_prime_p18 = '$' . number_format($prime_calc_details[$clientId]['benefit_cost_prime_p18'], 2);
        $page->drawText("$benefit_cost_prime_p18", 350, 350);


        $total_benefit_cost_p20 = '$' . number_format($prime_calc_details[$clientId]['total_benefit_cost_p20'], 2);
        $page->drawText("$total_benefit_cost_p20", 530, 350);

        $page->drawText("Stmnt cost ", 30, 335);

        $statement_cost_ccmed_p22 = '$' . number_format($prime_calc_details[$clientId]['statement_cost_ccmed_p22'], 2);
        $page->drawText("$statement_cost_ccmed_p22", 300, 335);

        $statement_cost_prime_p21 = '$' . number_format($prime_calc_details[$clientId]['statement_cost_prime_p21'], 2);
        $page->drawText("$statement_cost_prime_p21", 350, 335);


        $total_statement_cost_p23 = '$' . number_format($prime_calc_details[$clientId]['total_statement_cost_p23'], 2);
        $page->drawText("$total_statement_cost_p23", 530, 335);

        $page->drawText("Sales Bonus", 30, 320);
        $sales_bonus_P24 = '$' . number_format($prime_calc_details[$clientId]['sales_bonus_P24'], 2);
        $page->drawText("$sales_bonus_P24", 530, 320);

        $page->drawText("Small Bal accounts costs X $.554", 30, 305);
        $small_balance_acc_cost_p25 = '$' . number_format($prime_calc_details[$clientId]['small_balance_acc_cost_p25'], 2);
        $page->drawText("$small_balance_acc_cost_p25", 530, 305);

        $page->drawText("Other Direct Costs", 30, 290);
        $other_direct_cost_prime_p26 = '$' . number_format($prime_calc_details[$clientId]['other_direct_cost_prime_p26'], 2);
        $page->drawText("$other_direct_cost_prime_p26", 300, 290);

        $other_direct_cost_ccmed_p27 = '$' . number_format($prime_calc_details[$clientId]['other_direct_cost_ccmed_p27'], 2);
        $page->drawText("$other_direct_cost_ccmed_p27", 350, 290);

        $other_direct_cost_total_p28 = '$' . number_format($prime_calc_details[$clientId]['other_direct_cost_total_p28'], 2);
        $page->drawText("$other_direct_cost_total_p28", 530, 290);
        $page->drawLine(25, 285, 580, 285);

        $page->drawText("TOTAL DIRECT COSTS", 30, 270);
        $total_direct_cost_p29 = '$' . number_format($prime_calc_details[$clientId]['total_direct_cost_p29'], 2);
        $page->drawText("$total_direct_cost_p29", 530, 270);

        $page->drawText("Client legal amount earned us", 30, 255);
        $client_legal_amount_earned_us_p30 = '$' . number_format($prime_calc_details[$clientId]['client_legal_amount_earned_us_p30'], 2);
        $page->drawText("$client_legal_amount_earned_us_p30", 300, 255);

        $page->drawText("Total legal amount earned us", 30, 240);
        $total_legal_amount_earned_p31 = '$' . number_format($prime_calc_details[$clientId]['total_legal_amount_earned_p31'], 2);
        $page->drawText("$total_legal_amount_earned_p31", 300, 240);

        $page->drawText("LEGAL EXPENSES", 30, 225);
        $legal_expenses_customer_p33 = '$' . number_format($prime_calc_details[$clientId]['legal_expenses_customer_p33'], 2);
        $page->drawText("$legal_expenses_customer_p33", 530, 225);

        $page->drawText("Number of Active Clients as of today : ", 30, 210);
        $number_of_active_customers_p34 = $prime_calc_details[$clientId]['number_of_active_customers_p34'];
        $page->drawText("$number_of_active_customers_p34", 300, 210);

        $page->drawText("Average cost per account ", 30, 195);
        $avg_cost_per_acc_p35 = $prime_calc_details[$clientId]['avg_cost_per_acc_p35'];
        $page->drawText("$avg_cost_per_acc_p35", 300, 195);

        $page->drawText("TOTAL COST OF COLLECTION ", 30, 180);
        $total_cost_of_collections_p36 = '$' . number_format($prime_calc_details[$clientId]['total_cost_of_collections_p36'], 2);
        $page->drawText("$total_cost_of_collections_p36", 530, 180);

        $page->drawText("TOTAL PROFIT / LOSS", 30, 160);
        $total_profit_loss_p37 = '$' . number_format($prime_calc_details[$clientId]['total_profit_loss_p37'], 2);
        $page->drawText("$total_profit_loss_p37", 530, 160);

        $page->drawText("INDIRECT COSTS ", 30, 140);
        $indirect_cost_per_customer_p39 = '$' . number_format($prime_calc_details[$clientId]['indirect_cost_per_customer_p39'], 2);
        $page->drawText("$indirect_cost_per_customer_p39", 530, 140);

        $page->drawText("TOTAL PROFIT/LOSS W INDIR", 30, 120);
        $total_profit_loss_incl_indirect_p40 = '$' . number_format($prime_calc_details[$clientId]['total_profit_loss_incl_indirect_p40'], 2);
        $page->drawText("$total_profit_loss_incl_indirect_p40", 530, 120);



        $page->drawLine(25, 175, 580, 175);

        $page->setFillColor(new Zend_Pdf_Color_Html('#7ac143'));

        $page->setLineColor(new Zend_Pdf_Color_Html('#7ac143'));
        $page->drawLine(20, 35, 570, 35);

        $page->setFont($font, 10)->drawText("CONFIDENTIAL @ Allicance Collection Service, Inc. All Rights Reserved", 20, 20)
                ->drawText("Page 1 of 1", 505, 20);

        $pdf->pages[] = $page;

        $pdf->save($fullPath);

        return $fullPath;
    }

    function saveClientAceReport($proj_clientId) {

        //$clientModelObject = new Application_Model_ClientModel(); 

        $data = $this->getClientDetail("$proj_clientId");

        $clientName = $data[$proj_clientId]['client_name'];
        $clientId = $data[$proj_clientId]['client_id'];
        $projectId = $data[$proj_clientId]['project_id'];

        $aces_es1 = $data[$proj_clientId]['aces_es1'];
        $aces_es2 = $data[$proj_clientId]['aces_es2'];
        $aces_es3 = $data[$proj_clientId]['aces_es3'];
        $aces_esf = $data[$proj_clientId]['aces_esf'];

        if ($aces_es1 == 0 && $aces_es2 == 0 && $aces_es3 == 0 && $aces_esf == 0) {
            return false;
        }

        $ace_calc_details = $this->getAcesCalcDetails($clientId);
        $ace_calc_details[$clientId]['avg_age_account_a9'] = $data[$proj_clientId]['age'];
        print_r($ace_calc_details);
        die;

        $projectArr = $this->getProjectDetails($projectId);
        $projectName = $projectArr[$projectId]['project_name'];

        $fileName = $clientId . '.pdf';

        $folderPath1 = "public/report/project_ace_" . $projectId;

        if (!is_dir($folderPath1)) {
            mkdir($folderPath1, 0777);
        }

        $folderPath = "public/report/project_ace_" . $projectId . "/" . $clientId;

        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777);
        }

        $fullPath = "public/report/project_ace_" . $projectId . "/" . $clientId . "/" . $fileName;

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        $pdf = new Zend_Pdf();
        $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER_BOLD_ITALIC);


        // Draw rectangle 
        $page->setFillColor(new Zend_Pdf_Color_Html('#00661A'));
        $page->setLineColor(new Zend_Pdf_Color_Html('#FFFFFF'));
        //$page->setLineDashingPattern(array(3, 2, 3, 4), 1.6); 
        $page->drawRectangle(20, 760, 580, 800);


        $page->setFillColor(new Zend_Pdf_Color_Html('#FFFFFF'));

        $page->setFont($font, 18)->drawText("ACES CUSTOMER PUP REPORT", 220, 775);

        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);

        $page->setFillColor(new Zend_Pdf_Color_Html('#000000'));

        $page->setFont($font, 10)->drawText("Client Name : $clientName ", 25, 740);

        $page->setFont($font, 10)->drawText("Client Id : $clientId ", 25, 720);
        $today = date('Y-m-d');
        $page->drawText("Date : $today ", 470, 720);
        $page->drawText("Performance Evaluation : $projectName ", 25, 700);

        $page->setLineColor(new Zend_Pdf_Color_Html('#7ac143'));

        $page->drawLine(25, 680, 580, 680);

        $page->setLineColor(new Zend_Pdf_Color_Html('#8b8b8a'));

        $page->drawText("TOTAL", 300, 660);

        $page->drawLine(300, 655, 330, 655);

        $page->drawText("ES1's placed", 30, 640);
        $es1_a3 = $ace_calc_details[$clientId]['es1_a3'];
        $page->drawText("$es1_a3", 300, 640);

        $page->drawText("ES2's placed", 30, 625);
        $es1_a4 = $ace_calc_details[$clientId]['es2_a4'];
        $page->drawText("$es1_a4", 300, 625);

        $page->drawText("ES3's placed", 30, 610);
        $es1_a5 = $ace_calc_details[$clientId]['es3_a5'];
        $page->drawText("$es1_a5", 300, 610);

        $page->drawText("ES2's placed", 30, 595);
        $es1_a6 = $ace_calc_details[$clientId]['esf_a6'];
        $page->drawText("$es1_a6", 300, 595);

        $page->drawText("Total dollar volume placed (sql or pa)", 30, 580);
        $total_dollar_vol_a7 = $ace_calc_details[$clientId]['total_dollar_vol_a7'];
        $page->drawText("$total_dollar_vol_a7", 300, 580);

        $page->drawText("Total dollars recovered", 30, 565);
        $total_dollar_vol_recovered_a8 = $ace_calc_details[$clientId]['total_dollar_vol_recovered_a8'];
        $page->drawText("$total_dollar_vol_recovered_a8", 300, 565);

        $page->drawText("Average age of account", 30, 550);
        $avg_age_account_a9 = $ace_calc_details[$clientId]['avg_age_account_a9'];
        $page->drawText("$avg_age_account_a9", 300, 550);

        $page->setLineColor(new Zend_Pdf_Color_Html('#7ac143'));
        $page->drawLine(25, 535, 580, 535);

        $page->drawText("Fee Amt", 30, 520);
        $fee_amount_a10 = $ace_calc_details[$clientId]['fee_amount_a10'];
        $page->drawText("$fee_amount_a10", 300, 520);

        $page->drawText("Misc Fee", 30, 505);
        $misc_fee_a11 = $ace_calc_details[$clientId]['misc_fee_a11'];
        $page->drawText("$misc_fee_a11", 300, 505);

        $page->drawText("Total Fee", 30, 490);
        $total_fees_a12 = $ace_calc_details[$clientId]['total_fees_a12'];
        $page->drawText("$total_fees_a12", 300, 490);

        $page->drawText("DIRECT COSTS", 30, 465);
        $page->drawLine(25, 458, 580, 458);

        $page->drawText("Labor cost for collectors", 30, 445);
        $labor_cost_a13 = $ace_calc_details[$clientId]['labor_cost_a13'];
        $page->drawText("$labor_cost_a13", 300, 445);

        $page->drawText("Benefit costs", 30, 430);
        $benefit_cost_a14 = $ace_calc_details[$clientId]['benefit_cost_a14'];
        $page->drawText("$benefit_cost_a14", 300, 430);

        $page->drawText("Stmnt cost per acct @ x .554", 30, 415);
        $statement_cost_a15 = $ace_calc_details[$clientId]['statement_cost_a15'];
        $page->drawText("$statement_cost_a15", 300, 415);

        $page->drawText("Sales Bonus", 30, 400);
        $sales_bonus_a16 = $ace_calc_details[$clientId]['sales_bonus_a16'];
        $page->drawText("$sales_bonus_a16", 300, 400);

        $page->drawText("Other Direct Costs", 30, 385);
        $other_direct_cost_a17 = $ace_calc_details[$clientId]['other_direct_cost_a17'];
        $page->drawText("$other_direct_cost_a17", 300, 385);

        $page->drawLine(25, 370, 580, 370);

        $page->drawText("TOTAL DIRECT COSTS", 30, 355);
        $total_direct_cost_a18 = $ace_calc_details[$clientId]['total_direct_cost_a18'];
        $page->drawText("$total_direct_cost_a18", 300, 355);

        $page->drawText("Number of Active Clients as of today", 30, 340);
        $total_number_active_customers_a19 = $ace_calc_details[$clientId]['total_number_active_customers_a19'];
        $page->drawText("$total_number_active_customers_a19", 300, 340);

        $page->drawText("Average cost per account", 30, 325);
        $avg_cost_per_account_a20 = $ace_calc_details[$clientId]['avg_cost_per_account_a20'];
        $page->drawText("$avg_cost_per_account_a20", 300, 325);

        $page->drawText("TOTAL COST OF COLLECTION", 30, 310);
        $total_cost_collection_a20_1 = $ace_calc_details[$clientId]['total_cost_collection_a20_1'];
        $page->drawText("$total_cost_collection_a20_1", 300, 310);

        $page->drawLine(25, 295, 580, 295);

        $page->drawText("TOTAL PROFIT / LOSS", 30, 275);
        $total_profit_lost_a21 = $ace_calc_details[$clientId]['total_profit_lost_a21'];
        $page->drawText("$total_profit_lost_a21", 300, 275);

        $page->drawText("INDIRECT COSTS", 30, 255);
        $indirect_cost_per_company_a23 = $ace_calc_details[$clientId]['indirect_cost_per_company_a23'];
        $page->drawText("$indirect_cost_per_company_a23", 300, 255);


        $page->drawText("TOTAL PROFIT / LOSS w INDIR", 30, 235);
        $total_profit_loss_indirect_a24 = $ace_calc_details[$clientId]['total_profit_loss_indirect_a24'];
        $page->drawText("$total_profit_loss_indirect_a24", 300, 235);

        $page->drawLine(25, 215, 580, 215);





        $page->setFillColor(new Zend_Pdf_Color_Html('#7ac143'));
        $page->setLineColor(new Zend_Pdf_Color_Html('#7ac143'));
        $page->drawLine(20, 35, 570, 35);

        $page->setFont($font, 10)->drawText("Copyright @ Allicance Collection Service Inc All Rights Reserved", 20, 20)
                ->drawText("Page 1 of 1", 505, 20);

        $pdf->pages[] = $page;

        $pdf->save($fullPath);

        return $fullPath;
    }

    function saveajax($projectClientId, $columnName, $data) {


        $registry = Zend_Registry::getInstance();
        $DB = $registry['DB'];

        $clientInfo[$columnName] = $data;

        if ($projectClientId > 0) {
            $DB->update('tbl_clients', $clientInfo, " proj_client_id = $projectClientId  ");
        }

        return $data;
    }

    function saveProjectPrimeFile($proj_clientId) {
        unset($result);

        $data = $this->getClientDetail("$proj_clientId");

        $clientName = $data[$proj_clientId]['client_name'];
        $clientId = $data[$proj_clientId]['client_id'];
        $projectId = $data[$proj_clientId]['project_id'];
        $groupId = $data[$proj_clientId]['client_id_group'];

        $aces_es1 = $data[$proj_clientId]['aces_es1'];
        $aces_es2 = $data[$proj_clientId]['aces_es2'];
        $aces_es3 = $data[$proj_clientId]['aces_es3'];
        $aces_esf = $data[$proj_clientId]['aces_esf'];

        if (($aces_es1 > 0) || ($aces_es2 > 0) || ($aces_es3 > 0) || ($aces_esf > 0)) {
            return false;
        }



        $projectArr = $this->getProjectDetails($projectId);
        $projectName = $projectArr[$projectId]['project_name'];

        $prime_calc_details = $this->getPupCalcDetails($clientId);
        $prime_calc_details[$clientId]['avg_age_of_account_p9_3'] = $data[$proj_clientId]['age'];


        $large_bal_account_p3 = intval($prime_calc_details[$clientId]['large_bal_account_p3']);

        $medium_bal_account_p4 = intval($prime_calc_details[$clientId]['medium_bal_account_p4']);

        $small_bal_account_p5 = intval($prime_calc_details[$clientId]['small_bal_account_p5']);

        $controlled_cost_account_p6 = intval($prime_calc_details[$clientId]['controlled_cost_account_p6']);

        $total_dollar_volume_p7 = '$' . number_format($prime_calc_details[$clientId]['total_dollar_volume_p7'], 2);

        $non_legal_dollars_recovered_p8 = '$' . number_format($prime_calc_details[$clientId]['non_legal_dollars_recovered_p8'], 2);

        $legal_dollars_recovered_p9 = '$' . number_format($prime_calc_details[$clientId]['legal_dollars_recovered_p9'], 2);

        $total_dollars_recovered_p9_2 = '$' . number_format($prime_calc_details[$clientId]['total_dollars_recovered_p9_2'], 2);

        $avg_age_of_account_p9_3 = intval($prime_calc_details[$clientId]['avg_age_of_account_p9_3']);

        $avg_balance_p9_4 = '$' . number_format($prime_calc_details[$clientId]['avg_balance_p9_4'], 2);

        $recovery_rate_p11 = $prime_calc_details[$clientId]['recovery_rate_p11'] * 100;

        $fee_rate_p10 = $prime_calc_details[$clientId]['fee_rate_p10'];

        $nonlegal_fees_p12_2 = '$' . number_format($prime_calc_details[$clientId]['nonlegal_fees_p12_2'], 2);

        $cc_attorney_fees_p13 = '$' . number_format($prime_calc_details[$clientId]['cc_attorney_fees_p13'], 2);

        $total_fees_p12 = '$' . number_format($prime_calc_details[$clientId]['total_fees_p12'], 2);

        $avg_fee_per_account_p14 = $prime_calc_details[$clientId]['avg_fee_per_account_p14'];

        $labot_cost_for_collectors_contr_p16 = '$' . number_format($prime_calc_details[$clientId]['labot_cost_for_collectors_contr_p16'], 2);

        $labot_cost_for_collectors_prime_p15 = '$' . number_format($prime_calc_details[$clientId]['labot_cost_for_collectors_prime_p15'], 2);

        $total_labor_cost_p17 = '$' . number_format($prime_calc_details[$clientId]['total_labor_cost_p17'], 2);

        $benefit_cost_ccmed_p19 = '$' . number_format($prime_calc_details[$clientId]['benefit_cost_ccmed_p19'], 2);

        $benefit_cost_prime_p18 = '$' . number_format($prime_calc_details[$clientId]['benefit_cost_prime_p18'], 2);

        $total_benefit_cost_p20 = '$' . number_format($prime_calc_details[$clientId]['total_benefit_cost_p20'], 2);

        $statement_cost_ccmed_p22 = '$' . number_format($prime_calc_details[$clientId]['statement_cost_ccmed_p22'], 2);

        $statement_cost_prime_p21 = '$' . number_format($prime_calc_details[$clientId]['statement_cost_prime_p21'], 2);

        $total_statement_cost_p23 = '$' . number_format($prime_calc_details[$clientId]['total_statement_cost_p23'], 2);

        $sales_bonus_P24 = '$' . number_format($prime_calc_details[$clientId]['sales_bonus_P24'], 2);

        $small_balance_acc_cost_p25 = '$' . number_format($prime_calc_details[$clientId]['small_balance_acc_cost_p25'], 2);

        $other_direct_cost_prime_p26 = '$' . number_format($prime_calc_details[$clientId]['other_direct_cost_prime_p26'], 2);

        $other_direct_cost_ccmed_p27 = '$' . number_format($prime_calc_details[$clientId]['other_direct_cost_ccmed_p27'], 2);

        $other_direct_cost_total_p28 = '$' . number_format($prime_calc_details[$clientId]['other_direct_cost_total_p28'], 2);

        $total_direct_cost_p29 = '$' . number_format($prime_calc_details[$clientId]['total_direct_cost_p29'], 2);

        $client_legal_amount_earned_us_p30 = '$' . number_format($prime_calc_details[$clientId]['client_legal_amount_earned_us_p30'], 2);

        $total_legal_amount_earned_p31 = '$' . number_format($prime_calc_details[$clientId]['total_legal_amount_earned_p31'], 2);

        $legal_expenses_customer_p33 = '$' . number_format($prime_calc_details[$clientId]['legal_expenses_customer_p33'], 2);

        $number_of_active_customers_p34 = $prime_calc_details[$clientId]['number_of_active_customers_p34'];

        $avg_cost_per_acc_p35 = $prime_calc_details[$clientId]['avg_cost_per_acc_p35'];

        $total_cost_of_collections_p36 = '$' . number_format($prime_calc_details[$clientId]['total_cost_of_collections_p36'], 2);

        $total_profit_loss_p37 = '$' . number_format($prime_calc_details[$clientId]['total_profit_loss_p37'], 2);

        $indirect_cost_per_customer_p39 = '$' . number_format($prime_calc_details[$clientId]['indirect_cost_per_customer_p39'], 2);

        $total_profit_loss_incl_indirect_p40 = '$' . number_format($prime_calc_details[$clientId]['total_profit_loss_incl_indirect_p40'], 2);

        $result = array($clientName, $clientId, $groupId, $large_bal_account_p3, $medium_bal_account_p4, $small_bal_account_p5, $controlled_cost_account_p6, $total_dollar_volume_p7, $non_legal_dollars_recovered_p8, $legal_dollars_recovered_p9, $total_dollars_recovered_p9_2, $avg_age_of_account_p9_3, $avg_balance_p9_4, $recovery_rate_p11, $fee_rate_p10, $nonlegal_fees_p12_2, $cc_attorney_fees_p13, $total_fees_p12, $avg_fee_per_account_p14, $labot_cost_for_collectors_contr_p16, $labot_cost_for_collectors_prime_p15, $total_labor_cost_p17, $benefit_cost_ccmed_p19, $benefit_cost_prime_p18, $total_benefit_cost_p20, $statement_cost_ccmed_p22, $statement_cost_prime_p21, $total_statement_cost_p23, $sales_bonus_P24, $small_balance_acc_cost_p25, $other_direct_cost_prime_p26, $other_direct_cost_ccmed_p27, $other_direct_cost_total_p28, $total_direct_cost_p29, $client_legal_amount_earned_us_p30, $total_legal_amount_earned_p31, $legal_expenses_customer_p33, $number_of_active_customers_p34, $avg_cost_per_acc_p35, $total_cost_of_collections_p36, $total_profit_loss_p37, $indirect_cost_per_customer_p39, $total_profit_loss_incl_indirect_p40);

        return $result;
    }
    
    function saveProjectAcesFile($proj_clientId) {
        unset($result);
        
        $data = $this->getClientDetail("$proj_clientId");

        $clientName = $data[$proj_clientId]['client_name'];
        $clientId = $data[$proj_clientId]['client_id'];
        $projectId = $data[$proj_clientId]['project_id'];

        $aces_es1 = $data[$proj_clientId]['aces_es1'];
        $aces_es2 = $data[$proj_clientId]['aces_es2'];
        $aces_es3 = $data[$proj_clientId]['aces_es3'];
        $aces_esf = $data[$proj_clientId]['aces_esf'];

        if ($aces_es1 == 0 && $aces_es2 == 0 && $aces_es3 == 0 && $aces_esf == 0) {
            return false;
        }

        $ace_calc_details = $this->getAcesCalcDetails($clientId);
        $ace_calc_details[$clientId]['avg_age_account_a9'] = $data[$proj_clientId]['age'];

        $projectArr = $this->getProjectDetails($projectId);
        $projectName = $projectArr[$projectId]['project_name'];

        
        $es1_a3 = $ace_calc_details[$clientId]['es1_a3'];
        
        $es1_a4 = $ace_calc_details[$clientId]['es2_a4'];
        
        $es1_a5 = $ace_calc_details[$clientId]['es3_a5'];

        $es1_a6 = $ace_calc_details[$clientId]['esf_a6'];
        
        $total_dollar_vol_a7 = $ace_calc_details[$clientId]['total_dollar_vol_a7'];

        $total_dollar_vol_recovered_a8 = $ace_calc_details[$clientId]['total_dollar_vol_recovered_a8'];

        $avg_age_account_a9 = $ace_calc_details[$clientId]['avg_age_account_a9'];

        $fee_amount_a10 = $ace_calc_details[$clientId]['fee_amount_a10'];

        $misc_fee_a11 = $ace_calc_details[$clientId]['misc_fee_a11'];

        $total_fees_a12 = $ace_calc_details[$clientId]['total_fees_a12'];

        $labor_cost_a13 = $ace_calc_details[$clientId]['labor_cost_a13'];
        
        $benefit_cost_a14 = $ace_calc_details[$clientId]['benefit_cost_a14'];

        $statement_cost_a15 = $ace_calc_details[$clientId]['statement_cost_a15'];

        $sales_bonus_a16 = $ace_calc_details[$clientId]['sales_bonus_a16'];

        $other_direct_cost_a17 = $ace_calc_details[$clientId]['other_direct_cost_a17'];

        $total_direct_cost_a18 = $ace_calc_details[$clientId]['total_direct_cost_a18'];

        $total_number_active_customers_a19 = $ace_calc_details[$clientId]['total_number_active_customers_a19'];

        $avg_cost_per_account_a20 = $ace_calc_details[$clientId]['avg_cost_per_account_a20'];

        $total_cost_collection_a20_1 = $ace_calc_details[$clientId]['total_cost_collection_a20_1'];

        $total_profit_lost_a21 = $ace_calc_details[$clientId]['total_profit_lost_a21'];

        $indirect_cost_company_a22 = $ace_calc_details[$clientId]['indirect_cost_company_a22'];

        $indirect_cost_per_company_a23 = $ace_calc_details[$clientId]['indirect_cost_per_company_a23'];
        
        $total_placment = $total_dollar_vol_a7;
        
        $increaseincollection1 = ($total_dollar_vol_a7 * 0.01);
        
        $increaseincollection2 = ($total_dollar_vol_a7 * 0.02);
        
        $result = array($clientName, $clientId, $es1_a3, $es1_a4, $es1_a5, $es1_a6, $total_dollar_vol_a7, $total_dollar_vol_recovered_a8, $avg_age_account_a9, $fee_amount_a10, $misc_fee_a11, $total_fees_a12, $labor_cost_a13, $benefit_cost_a14, $statement_cost_a15, $sales_bonus_a16, $other_direct_cost_a17, $total_direct_cost_a18, $total_number_active_customers_a19, $avg_cost_per_account_a20, $total_cost_collection_a20_1, $total_profit_lost_a21, $indirect_cost_company_a22, $indirect_cost_per_company_a23, $total_placment, $increaseincollection1, $increaseincollection2);

        return $result;

}

}

// End of class

