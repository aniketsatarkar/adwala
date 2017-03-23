<?php

    include_once "dbcred.php";

    global $_CONN;

    if(!$_CONN)
    {
        echo "Failed To connect to Database !";
        die();
    }

    // --- Helper Functions -----------------------
    /************************************************************
     * Function to parse mysql Data-Time string to appropriate  *
     * date, time or datetime format.                           *
     * OPTIONS STRING : 'date', 'time', 'datetime'              *
     ************************************************************/
    function mysql_date_parse($sql_date_str, $get_option)
    {
        try
        {
            $date_arr = date_parse($sql_date_str);
        }
        catch(Exception $e)
        {
            return false;
        }

        $date = $date_arr['day'] . "-" . $date_arr['month'] . "-" . $date_arr['year'];
        $time = $date_arr['hour'] . ":" . $date_arr['minute'] . ":" . $date_arr['second'];
        $dateTime = $date . " " . $time;

        $get_option = strtolower($get_option);

        switch($get_option)
        {
            case "date":
                return $date;
                break;

            case "time":
                return $time;
                break;

            case "datetime":
                return $dateTime;
                break;
            default:
                return false;
        }
    }

    function getPostedAdCount($userID, $conn)
    {
        try
        {
            $query = "SELECT COUNT(id) FROM advertisement WHERE adv_posted_by=$userID";
            $result = mysqli_query($conn, $query);
            $resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);

            if(sizeof($resultArray) == 0)
                return 0;
            else
                return $resultArray[0][0];
        }
        catch(mysqli_sql_exception $e)
        {
            return -1;
        }
    }

    function getSavedAdCount($userId, $conn)
    {
        try
        {
            $query = "SELECT COUNT(id) FROM savedad WHERE saved_by=$userId";
            $result = mysqli_query($conn, $query);
            $resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);

            if(sizeof($resultArray) == 0)
                return 0;
            else
                return $resultArray[0][0];
        }
        catch(mysqli_sql_exception $e)
        {
            return -1;
        }
    }

    function getUploadsCount($userId, $conn)
    {
        try
        {
            $query = "SELECT COUNT(*) FROM fileupload WHERE uploaded_by=$userId";
            $result = mysqli_query($conn, $query);
            $resultArray = mysqli_fetch_all($result, MYSQLI_BOTH);

            if(sizeof($resultArray) == 0)
                return 0;
            else
                return $resultArray[0][0];
        }
        catch(mysqli_sql_exception $e)
        {
            return -1;
        }
    }

    function getEditionNameList($editionIdList)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect To Database !";
            die();
        }

        $query = "SELECT edition_name FROM edition WHERE edition_id IN ($editionIdList)";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
        {
            echo "No Data Found !";
            die();
        }

        $editionList_str = "";

        for($i=0; $i<sizeof($resultArray); $i++)
        {
            $editionName = $resultArray[$i]['edition_name'];
            $editionList_str .= $editionName . ", ";
        }

        return substr($editionList_str, 0, strlen($editionList_str)-2);
    }
    // --------------------------------------------


    // --- Error Message Helpers ------------------
    function cartIsEmpty()
    {
        echo "<div class='row section center'><h4 class='grey-text lighten-4'>There Is Nothing In Your Cart !</h4></div>";
        die();
    }

    function noOffersFound()
    {
        echo "<div class='row section center'><h4 class='grey-text lighten-4'>Sorry, There Are No Offer !</h4></div>";
        die();
    }

    function noCouponFound()
    {
        echo "<div class='row section center'><h4 class='grey-text lighten-4'>You Don't Have Any Coupons !</h4></div>";
        die();
    }

    function noPostedAdsFound()
    {
        echo "<div class='row section center'><h4 class='grey-text lighten-4'>You Didn't Post Any Ad Yet !</h4></div>";
        die();
    }

    function noSavedAdsFound()
    {
        echo "<div class='row section center'><h4 class='grey-text lighten-4'>There Are No Saved Ads !</h4></div>";
        die();
    }

    function noFilesFound()
    {
        echo "<div class='row section center'><h4 class='grey-text lighten-4'>There Are No Files To Show !</h4></div>";
        die();
    }
    // --------------------------------------------


    // function to get User-Profile-SideNav
    function getUserSideNav($userId)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect To Database !";
            die();
        }

        $query = "SELECT usr_name, usr_email, usr_profile_image FROM user WHERE usr_id = $userId";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
        {
            echo "No Data Found !";
            die();
        }

        $email = $resultArray[0]['usr_email'];
        $fullName = $resultArray[0]['usr_name'];
        $profileImage = $resultArray[0]['usr_profile_image'];

        echo "<li> 
				<div class='userView teal'> 
					<img class='circle' src='$profileImage'/> 
					<span class='white-text name'> $fullName </span> 
					<span class='white-text email'> $email </span> 
				</div> 
			</li> 
			<li> 
				<a class='waves-effect teal lighten-2' onclick='showDashboard(this)'>
					<i class='material-icons'>dashboard</i>Dashboard
				</a> 
			</li> 
			<li> 
				<div class='divider' style='margin-bottom: 7px'></div> 
			</li> 
			<li> 
				<a class='waves-effect' onclick='showCart(this)'>
					<i class='material-icons'>shopping_cart</i>Cart
				</a> 
			</li> 
			<li> 
				<div class='divider' style='margin-bottom: 7px'></div> 
			</li> 
			<li> 
				<a class='waves-effect' onclick='showMyOffers(this)'>
					<i class='material-icons'>save</i>Offers</a> 
			</li> 
			<li> 
				<a class='waves-effect' onclick='showCoupons(this)'>
					<i class='material-icons'>save</i>Coupons
				</a> 
			</li> 
			<li> 
				<a class='waves-effect' onclick='showMyAds(this)'>
					<i class='material-icons'>history</i>Posted Ads
				</a> 
			</li> 
			<li> 
				<a class='waves-effect' onclick='showSavedAds(this)'>
					<i class='material-icons'>save</i>Saved Ads
				</a> 
			</li> 
			<li> 
				<a class='waves-effect' onclick='showMyFiles(this)'>
					<i class='material-icons'>data</i>My Files
				</a> 
			</li> 
			<li> 
				<div class='divider' style='margin-bottom: 7px'></div> 
			</li> 
			<li> 
				<a class='waves-effect' onclick='showSettings(this)'>
					<i class='material-icons'>settings</i>Settings</a> 
			</li> 
			<li> 
				<a class='waves-effect' onclick='logout()'>
					<i class='material-icons'>close</i>Logout</a> 
			</li>";
    }

    // function to get Account Summery details for user !
    function getAccountSummery($userId)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect To Database !";
            die();
        }

        $postedAdCount = getPostedAdCount($userId, $_CONN);
        $savedAdCount  = getSavedAdCount($userId, $_CONN);
        $uploadsCount  = getUploadsCount($userId, $_CONN);

        echo "<blockquote>
                    <h5>Account Summary</h5>
                </blockquote>
                <div class='divider'></div>
                <table class='centered'>
                    <thead>
                        <th>Ads Posted</th>
                        <th>Saved Ads</th>
                        <th>Uploads</th>
                        <th>Offers</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>$postedAdCount</td>
                            <td>$savedAdCount</td>
                            <td>$uploadsCount</td>
                            <td>-1</td>
                        </tr>
                    </tbody>
                </table>";
    }

    // function to populate cart for user.
    function getCart($userId)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect To Database !";
            die();
        }

        $query = "SELECT
                        id, adv_text, adv_image, adv_cost, adv_payment_status, paper_name, edition_name, adtype_name
                    FROM
                        adwala.advertisement
                        JOIN adwala.rate
                        JOIN adwala.newspaper
                        JOIN adwala.edition
                        JOIN adwala.adtype
                    WHERE
                        advertisement.adv_posted_by = $userId
                        AND advertisement.adv_payment_status != 'paid'
                        AND rate.rate_id = advertisement.adv_rate
                        AND newspaper.paper_id = rate.paper_id
                        AND edition.edition_id = rate.edition_id
                        AND adtype.adtype_id = rate.adtype_id";

        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0) cartIsEmpty();

        echo "<blockquote>
                    <h5>Cart</h5>
                </blockquote>
                <div class='divider'></div>
                <div class='row'>
                    <table class='centered highlight'>
                        <thead>
                            <th>Ad</th>
                            <th>Newspaper</th>
                            <th>Edition</th>
                            <th>Ad Type</th>
                            <th>Cost</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>";

        $totalCost = 0;

        for($i=0; $i<sizeof($resultArray); $i++)
        {
            $ad = "";


            if($resultArray[0]['adv_text'] != "un")
            {
                $ad = $resultArray[$i]['adv_text'];
            }
            else if($resultArray[0]['adv_image'] != "un")
            {
                $imagePath = $resultArray[$i]['adv_image'];
                $ad = "<img class='materialboxed' width='80' src='$imagePath'>";
            }

            $newspaperName = $resultArray[$i]['paper_name'];
            $editionName = $resultArray[$i]['edition_name'];
            $adtypeName = $resultArray[$i]['adtype_name'];
            $adCost = $resultArray[$i]['adv_cost'];
            $paymentStatus = $resultArray[$i]['adv_payment_status'];
            $adId = $resultArray[$i]['id'];

            $totalCost += $adCost;

            echo "<tr>
                        <td>$ad</td>
                        <td>$newspaperName</td>
                        <td>$editionName</td>
                        <td>$adtypeName</td>
                        <td>&#8377;$adCost</td>
                        <td>$paymentStatus</td>
                        <td width='120px'>
                        <div class='col 2 s12'>
                            <div class='col s6 no-padding center'>
                                <a class='btn waves-effect no-padding lighten-4' data-ad-cost='$adCost' data-adid='$adId' onclick='payThisAd_btn(this)'><i class='material-icons tooltipped' data-tooltip='Pay This Ad' style='margin-left: 8px; margin-right: 8px'>check</i></a>
                            </div>
                            <div class='col s6 no-padding center'>
                                <a class='btn waves-effect red lighten-4 no-padding' data-adid='$adId' onclick='deleteFromCart_btn(this)'><i class='material-icons tooltipped' data-tooltip='Remove From Cart' style='margin-left: 8px; margin-right: 8px'>close</i></a>
                            </div>
                        </div>
                        </td>
                    </tr>";
        }

        echo "<tr class='grey lighten-4'>
                                <td colspan='4' style='font-weight: bold'>Total</td>
                                <td style='font-weight: bold'>&#8377;$totalCost</td>
                                <td colspan='2'>
                                    <a class='btn'>Check Out</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>";
    }

    // function to get offers for user.
    function getOffers()
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Filed To Connect To Database !";
            die();
        }

        $query = "SELECT
                            offer_ads_count, offer_editions ,offer_rate, offer_title, offer_desc,
                            paper_name, adtype_name, class_name
                        FROM
                            adwala.offer
                            JOIN adwala.newspaper
                            JOIN adwala.adtype
                            JOIN adwala.classifiedtype
                        WHERE
                            newspaper.paper_id 	= offer.offer_paper
                            AND adtype.adtype_id = offer.offer_ad_type
                            AND classifiedtype.class_id = offer_class_type";

        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0) noOffersFound();

        echo "<blockquote><h5>Offers</h5></blockquote><div class='divider'></div>";

        for($i=0; $i<sizeof($resultArray); $i++)
        {
            $paper = $resultArray[$i]['paper_name'];
            $adType = $resultArray[$i]['adtype_name'];
            $classType = $resultArray[$i]['class_name'];

            $editions =  $resultArray[$i]['offer_editions'];
            $editionsList = getEditionNameList($editions);

            $adsCount = $resultArray[$i]['offer_ads_count'];
            $rate = $resultArray[$i]['offer_rate'];
            $title =  $resultArray[$i]['offer_title'];
            $description = $resultArray[$i]['offer_desc'];

            echo "<div class='col s12 m6 l3'>
                    <div class='card no-padding'>
                        <div class='card-image waves-effect waves-block waves-light'>
                            <div style='position: absolute; top:10px; left:10px'>
                            <a href='composead1.php?adtype_id=1' class='btn-floating btn-large btn-price waves-effect waves-light blue  accent-2 tooltipped' data-tooltip='Compose Ad'>
                                <i class='material-icons'>mode_edit</i>
                            </a>
                            </div>
                            <img class='activator' src='images/classifieds.jpg' alt='offer_image'>
                        </div>
                        <div class='card-content #fafafa grey lighten-4'>
                            <h6 class='ligt italic' style='font-size:20px'>
                                $title
                            </h6>
                        </div>
                        <div class='card-reveal #fafafa grey lighten-5'>
                            <span class='card-title'>
                                <i class='material-icons right'>clear</i>
                            </span>
                            <div class='row'>
                                <div class='col s12' > $description </div>
                                <div class='col s12 division'>
                                    <ul>
                                        <li><b>Newspaper :</b> $paper </li>
                                        <li><b>Editions :</b> $editionsList </li>
                                        <li><b>Ad Type :</b> $adType </li>
                                        <li><b>Class Type :</b> $classType </li>
                                        <li><b>Total Ads :</b> $adsCount </li>
                                        <li><b>Offer Price :</b> &#8377;$rate </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
        }
    }

    // function to deduct coupon amount From advertisement...
    function deductAdCost($adId, $deductionAmount)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed to connect to database !";
            die();
        }

        $query = "SELECT * FROM advertisement WHERE id=$adId";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
        {
            echo "No data found !";
            die();
        }

        $adCost = $resultArray[0]['adv_cost'];
        $deductedCost = $adCost - $deductionAmount;

        $query = "UPDATE advertisement SET adv_cost=$deductedCost WHERE id=$adId";
        $result = mysqli_query($_CONN, $query);

        if($result)
            return true;
        else
            return false;
    }

    // function to get coupons for user.
    function getCoupons($userId)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed to Connect to Database !";
            die();
        }


        $query = "SELECT * FROM coupon WHERE coupon_for=$userId AND is_coupon_used=0";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0) noCouponFound();

        echo "<blockquote> <h5>Coupons</h5> </blockquote> <div class='divider'></div> <table class='centered highlight'> <thead> <th>Coupon Code</th> <th>Coupon Amount</th> <th>Use Coupon</th> </thead> <tbody>";

        for($i=0; $i<sizeof($resultArray); $i++)
        {
            $couponCode = $resultArray[$i]['coupon_code'];
            $couponAmount = $resultArray[$i]['coupon_amount'];

            echo "<tr><td>$couponCode</td><td>&#8377;$couponAmount</td><td><a class='btn no-padding tooltipped' data-tooltip='Use Coupon' data-coupon-code='$couponCode' onclick='useCoupon_btn(this)'><i class='material-icons' style='margin-left: 8px; margin-right: 8px'>check</i></a></td></tr>";
        }

        echo "</tbody></table>";
    }

    // function to use coupon using coupon Code.
    function useCoupon($userId, $adId, $couponCode)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed to connect to database !";
            die();
        }

        // check if the coupon exists >>>
        $query = "SELECT * FROM adwala.coupon WHERE coupon_for=$userId AND coupon_code='$couponCode';";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
        {
            $return_result = array("status"=>"failed", "message"=>"no_coupon_found");
            echo json_encode($return_result);
            return;
        }

        // check if coupon is used or not >>>
        $isCouponUsed = $resultArray[0]['is_coupon_used'];

        if($isCouponUsed != 0)
        {
            $return_result = array("status"=> "failed", "message" => "coupon_is_used");
            echo json_encode($return_result);
            return;
        }
        else if($isCouponUsed == 0)
        {
            $couponId = $resultArray[0]['coupon_id'];
            $couponAmount = $resultArray[0]['coupon_amount'];

            // set coupon as used and return coupon amount >>>
            $query = "UPDATE coupon SET is_coupon_used=1 WHERE coupon_id =$couponId";
            $result = mysqli_query($_CONN, $query);

            if(!$result)
            {
                $return_result = array("status" => "failed", "message" => "something_went_wrong");
                echo json_encode($return_result);
                return;
            }
            else
            {
                if(deductAdCost($adId, $couponAmount))
                {
                    $return_result = array("status" => "successful", "coupon_amount"=> $couponAmount);
                    echo json_encode($return_result);
                    return;
                }
                else
                {
                    $return_result = array("status" => "failed", "message"=> "cost_deduction_failed");
                    echo json_encode($return_result);
                    return;
                }
            }
        }
    }

    // function to get posted ads by user.
    function getPostedAds($userId)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect To Database !";
            die();
        }

        $query = "SELECT
                    advertisement.id, adv_text, adv_image, adv_cost, adv_status, paper_name, edition_name, adtype_name
                FROM
                    adwala.advertisement
                    JOIN adwala.newspaper
                    JOIN adwala.edition
                    JOIN adwala.adtype
                    JOIN adwala.rate
                WHERE
                    advertisement.adv_posted_by=$userId
                    AND
                    (
                        advertisement.adv_status='posted'
                        OR advertisement.adv_status='processing'
                    )
                    AND advertisement.adv_payment_status='paid'
                    AND rate.rate_id = advertisement.adv_rate
                    AND newspaper.paper_id = rate.paper_id
                    AND edition.edition_id = rate.edition_id
                    AND adtype.adtype_id = rate.adtype_id";

        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0) noPostedAdsFound();

        echo "<blockquote> <h5>Posted Ads</h5> </blockquote> <div class='divider'></div> <table class='centered'> <thead> <th>Ad</th> <th>Newspaper</th> <th>Edition</th> <th>Ad Type</th> <th>Cost</th> <th style='width:100px'>Ad Status</th> <th style='width:100px'>Actions</th> </thead> <tbody>";

        for($i=0; $i<sizeof($resultArray); $i++)
        {
            $adBody = "";

            if($resultArray[0]['adv_text'] != "un")
            {
                $adBody = $resultArray[$i]['adv_text'];
            }
            else if($resultArray[0]['adv_image'] != "un")
            {
                $imagePath = $resultArray[$i]['adv_image'];
                $adBody = "<img class='materialboxed' width='80' src='$imagePath'>";
            }

            $adId = $resultArray[$i]['id'];
            $advCost = $resultArray[$i]['adv_cost'];
            $paperName = $resultArray[$i]['paper_name'];
            $editionName = $resultArray[$i]['edition_name'];
            $adtypeName = $resultArray[$i]['adtype_name'];
            $adStatus = $resultArray[$i]['adv_status'];

            echo "<tr>
						<td>
							$adBody
						</td>
						<td>$paperName</td>
						<td>$editionName</td>
						<td>$adtypeName</td>
						<td>&#8377;$advCost</td>
						<td>$adStatus</td>
						<td>
							<div class='row'>
								<div class='col s6 no-padding center'>
									<a class='btn waves-effect no-padding lighten-4' data-ad-id='$adId' onclick='func(this)'>
										<i class='material-icons tooltipped' data-tooltip='Re-Post This Ad' style='margin-left: 8px; margin-right: 8px'>edit</i>
									</a>
								</div>
								<div class='col s6 no-padding center'>
									<a class='btn waves-effect red no-padding' data-ad-id='$adId' onclick='deletePostedAd_btn(this)'>
										<i class='material-icons tooltipped' data-tooltip='Delete Ad' style='margin-left: 8px; margin-right: 8px'>delete</i>
									</a>
								</div>
							</div>
						</td>
					</tr>";
        }

        echo "</tbody></table>";
    }

    // function to get saved Ads
    function getSavedAds($userId)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect To Database !";
            die();
        }

        $query = "SELECT * FROM savedad WHERE saved_by=$userId";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0) noSavedAdsFound();

        echo "<blockquote> <h5>Saved Ads</h5> </blockquote> <div class='divider'></div> <table class='centered'> <thead> <th>Ad Body</th> <th style='width:100px'>Action</th> </thead> <tbody>";

        for($i=0; $i<sizeof($resultArray); $i++)
        {
            $adBody = "";
            $id = $resultArray[$i]['id'];

            if($resultArray[$i]['ad_text'] != "un")
                $adBody = $resultArray[$i]['ad_text'];
            else if($resultArray[$i]['ad_image'] != "un")
                $adBody = "<img class='materialboxed' width='80' src='$resultArray[$i]['ad_image']'>";

            echo "<tr>
	                <td>$adBody</td>
                    <td>
                        <div class='row'>
                            <div class='col s6 no-padding center'>
                                <a class='btn waves-effect no-padding lighten-4' data-id='$id' onclick='func(this)'>
                                    <i class='material-icons tooltipped' data-tooltip='Post This Ad' style='margin-left: 8px; margin-right: 8px'>edit</i>
                                </a>
                            </div>
                            <div class='col s6 no-padding center'>
                                <a class='btn waves-effect red no-padding' data-id='$id' onclick='deleteSavedAd_btn(this)'>
                                    <i class='material-icons tooltipped' data-tooltip='Delete Ad' style='margin-left: 8px; margin-right: 8px'>delete</i>
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>";
        }

        echo "</tbody></table>";
    }

    // function to get files.
    function getFiles($userId)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect to database !";
            die();
        }

        $query = "SELECT * FROM fileupload WHERE uploaded_by=$userId";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
        {
            echo "No Data Found !";
            die();
        }

        echo "<blockquote><h5>My Files</h5></blockquote> <div class='divider'></div> <table class='centered'> <thead> <th>File</th> <th>File Size</th> <th style='width:100px'>File Action</th></thead><tbody>";

        for($i=0; $i<sizeof($resultArray); $i++)
        {
            $id = $resultArray[$i]['id'];
            $filePath = $resultArray[$i]['file_path'];

            // resolve file name...
            // resolve file size in kb.

            if(!file_exists($filePath)) continue;

            $fileSize = (int)(filesize($filePath)/1024) . "KB";

            echo "<tr>
                  <td>$filePath</td>
                  <td>$fileSize</td>
                  <td>
                   <div class='row'>
                    <div class='col s6 no-padding center'>
                     <a class='btn waves-effect no-padding lighten-4' data-file-id='$id' onclick='func(this)'>
                      <i class='material-icons tooltipped' data-tooltip='Download File' style='margin-left: 8px; margin-right: 8px'>
                      edit</i>
                     </a>
                    </div>
                    <div class='col s6 no-padding center'>
                     <a class='btn waves-effect red no-padding' data-file-id='$id' onclick='deleteFile_btn(this)'>
                      <i class='material-icons tooltipped' data-tooltip='Delete File' style='margin-left: 8px; margin-right: 8px'>delete</i>
                     </a>
                    </div>
                   </div>
                  </td>
                 </tr>";
        }

        echo "</tbody></table>";
    }
	
    // function to get Settings
    function getSettings($userId)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect To Database !";
            die();
        }

        $query = "SELECT * FROM user WHERE usr_id=$userId";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
        {
            echo "No Data Found !";
            die();
        }

        $name = $resultArray[0]['usr_name'];
        $email = $resultArray[0]['usr_email'];
        $mobile = $resultArray[0]['usr_mobile'];
        $state = $resultArray[0]['usr_state'];
        $city = $resultArray[0]['usr_city'];
        $address = $resultArray[0]['usr_address'];

        echo "<blockquote>
					<h5>General Data</h5>
				</blockquote>
				<div class='divider'></div>
				<div class='col s12 card'>
					<div class='row section'>
						<div class='col s12 m6 l6 input-field'>
							<input id='user_fullname' disabled type='text' value='$name'>
							<label for='user_fullname'>Full Name</label>
						</div>
						<div class='col s12 m6 l6 input-field'>
							<input id='user_email' disabled type='text' value='$email'>
							<label for='user_email'>Email</label>
						</div>
						<div class='col s12 m6 l6 input-field'>
							<input id='user_mobile' disabled type='text' value='$mobile'>
							<label for='user_mobile'>Mobile</label>
						</div>
						<div class='col s12 m6 l6 input-field'>
							<input id='user_state' disabled type='text' value='$state'>
							<label for='user_state'>State</label>
						</div>
						<div class='col s12 m6 l6 input-field'>
							<input id='user_city' disabled type='text' value='$city'>
							<label for='user_city'>City</label>
						</div>
						<div class='col s12 m12 l12 input-field'>
							<textarea id='user_address' disabled  class='materialize-textarea'>$address</textarea>
							<label for='user_address'>Address</label>
						</div>
					</div>
					<div class='row right' style='margin-top: 0px'>
						<a class='btn' onclick='editUserDate_btn(this)'>Edit</a>
						<a id='save_settings_btn' class='btn' disabled onclick='saveUserDate_btn(this)'>Save</a>
					</div>
				</div>";
				
		echo "<script type='text/javascript'>Materialize.updateTextFields();</script>";
    }
	
    // function to update user data.
    function saveSettings($userId, $name, $email, $mobile, $city, $state, $address)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect To Database !";
            die();
        }

        $query = "UPDATE user SET
                    usr_name = '$name',
                    usr_email = '$email',
                    usr_mobile = '$mobile',
                    usr_address='$address',
                    usr_city='$city',
                    usr_state='$state'
                WHERE usr_id='$userId'";
        $result = mysqli_query($_CONN, $query);

        if($result)
        {
            $return_result = array("status"=> "successful", "message"=>"saved_success");
            echo json_encode($return_result);
            return;
        }
        else
        {
            $return_result = array("status"=> "failed", "message"=>"failed_to_save");
            echo json_encode($return_result);
            return;
        }
    }

	
    // function to remove ad from users cart.
    function deleteAdFromCart($adId)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect To Database !";
            die();
        }

        $query = "DELETE FROM advertisement WHERE id=$adId";
        $result = mysqli_query($_CONN, $query);

        if($result)
        {
            $return_result = array("status"=>"successful", "message"=>"ad_deleted");
            echo json_encode($return_result);
            return;
        }
        else
        {
            $return_result = array("status"=>"failed", "message"=>"ad_delete_failed");
            echo json_encode($return_result);
            return;
        }
    }

    // function to delete posted ad from history
    function deletePostedAd($adId)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect To Database !";
            die();
        }

        $query = "DELETE FROM advertisement WHERE id=$adId";
        $result = mysqli_query($_CONN, $query);

        if($result)
        {
            $return_result = array("status"=>"successful", "message"=>"deleted");
            echo json_encode($return_result);
            return;
        }
        else
        {
            $return_result = array("status"=>"failed", "message"=>"failed_to_delete");
            echo json_encode($return_result);
            return;
        }
    }

    // function to delete Saved Ad
    function deleteSavedAd($id)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect To Database !";
            die();
        }

        $query = "DELETE FROM savedad WHERE id=$id";
        $result = mysqli_query($_CONN, $query);

        if($result)
        {
            $return_result = array("status"=>"successful", "message"=>"deleted");
            echo json_encode($return_result);
            return;
        }
        else
        {
            $return_result = array("status" => "failed", "message"=>"failed_to_delete");
            echo json_encode($return_result);
            return;
        }
    }

    // function to delete file from database and file-system
    function deleteFile($id)
    {
        global $_CONN;

        if(!$_CONN)
        {
            echo "Failed To Connect To Database !";
            die();
        }

        $query = "SELECT * FROM fileupload WHERE id=$id";
        $result = mysqli_query($_CONN, $query);
        $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(sizeof($resultArray) == 0)
        {
            echo "No Data Found !";
            die();
        }

        $filePath = $resultArray[0]['file_path'];
        $is_file_deleted = false;

        if(file_exists($filePath))
            if(unlink($filePath))
                $is_file_deleted = true;


        $query = "DELETE FROM fileupload WHERE id=$id";
        $result = mysqli_query($_CONN, $query);

        if($result && $is_file_deleted)
        {
            $return_result = array("status"=>"successful", "message"=>"file_deleted");
            echo json_encode($return_result);
            return;
        }
        else if($result)
        {
            $return_result = array("status"=>"successful", "message"=>"data_deleted");
            echo json_encode($return_result);
            return;
        }
        else
        {
            $return_result = array("status"=>"failed", "message"=>"failed_to_delete");
            echo json_encode($return_result);
            return;
        }
    }

	
?>