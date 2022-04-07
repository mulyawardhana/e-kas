<!-- ============================ -->
<!-- ============== HEADER ============== -->
<?php include 'header.php'; ?>
<!-- ============== CONNECTIFY ============== -->
<?php include 'connect.php'; ?>
<!-- ============= BODY =============== -->
<!-- ============= SLIDE 1 =============== -->
<section class="slide1; p-b-25" style="margin-top:-37px;">
	<div class="w3-content w3-section" style="max-width:100%">
		<img class="mySlidesz" src="images/pcp/44_Gambar_pengganti_cabang&gerai.jpg" style="width:100%">
	</div>
</section>

<!-- ============= CONTENT =============== -->
<section class="blog bgwhite p-b-60 text-center">
	<div class="col-md-12 col-12">
		<span class="font-weight-bold pb-3"><h3 class="font-weight-bold">Cabang & Gerai</h3></span>
	</div>
	<script>
	var btns = btnContainer.getElementsByClassName("nav-item");
	// Loop through the buttons and add the active class to the current/clicked button
	for (var i = 0; i < btns.length; i++) {
		btns[i].addEventListener("click", function() {
			var current = document.getElementsByClassName("active");
			current[0].className = current[0].className.replace(" active", "");
			this.className += " active";
		});
	}
</script>
<?php if (isset($_GET['clicked'])) { $lok = $_GET['clicked'];} ?>
<!-- ============== BUTTON REGION ============== -->
<div class="container pt-3">
	<ul class="nav nav-pills nav-justified">
		<li class="nav-item nav-link <?php if($lok=="JABODETABEK"){ echo"active"; } ?>" sequence="1" value="" onclick="window.location.href='?clicked=JABODETABEK'">
			<a class="nav-link2 rounded focus" data-toggle="pill" href="?clicked=JABODETABEK">JABODETABEK</a>
		</li>
		<li class="nav-item nav-link mr-1 <?php if($lok=="JAWA"){ echo"active"; } ?>" sequence="2" value="JAWA" onclick="window.location.href='?clicked=JAWA'">
			<a class="nav-link2 rounded" data-toggle="pill" href="#jawa">JAWA</a>
		</li>
		<li class="nav-item nav-link mr-1 mw-100 <?php if($lok=="BALINTBNTT"){ echo"active"; } ?>"" sequence="3" value="BALI NTB & NTT" onclick="window.location.href='?clicked=BALINTBNTT'">
			<a class="nav-link2 rounded" style="width:max-content; data-toggle="pill" href="#bali">BALI NTB & NTT</a>
		</li>
		<li class="nav-item nav-link mr-1 <?php if($lok=="SUMATERA"){ echo"active"; } ?>"" sequence="4" value="SUMATERA" onclick="window.location.href='?clicked=SUMATERA'">
			<a class="nav-link2 rounded" data-toggle="pill" href="#sumatera">SUMATERA</a>
		</li>
		<li class="nav-item nav-link mr-1 <?php if($lok=="KALIMANTAN"){ echo"active"; } ?>"" sequence="5" value="KALIMANTAN" onclick="window.location.href='?clicked=KALIMANTAN'">
			<a class="nav-link2 rounded" data-toggle="pill" href="#kalimantan">KALIMANTAN</a>
		</li>
		<li class="nav-item nav-link mr-1 <?php if($lok=="SULAWESI"){ echo"active"; } ?>"" sequence="6" value="SULAWESI" onclick="window.location.href='?clicked=SULAWESI'">
			<a class="nav-link2 rounded" data-toggle="pill" href="#kalimantan">SULAWESI</a>
		</li>
		<li class="nav-item nav-link mr-1 mw-100  <?php if($lok=="MALUKUPAPUA"){ echo"active"; } ?>"" sequence="7" value="MALUKU & PAPUA" onclick="window.location.href='?clicked=MALUKUPAPUA'">
			<a class="nav-link2 rounded" style="width:max-content;" data-toggle="pill" href="#papua">MALUKU & PAPUA</a>
		</li>
	</ul>
	<!-- ============== LIST CABANG ============== -->
	<div class="mt-3">
		<div class="wrapper center-block">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="accordion" id="accordionExample">
					<?php
					if (isset($_GET['clicked'])) {
						$region = $_GET['clicked'];
                        if($region=="JABODETABEK"){
                            $data="a.`CityId` IN ('145','75','110','432','53') ";
                        }
                        if($region=="SUMATERA"){
                            $data="a.`ProvinceId` >=1 AND a.`ProvinceId` <=10 ";
                        }
                        if($region=="JAWA"){
                            $data="a.`ProvinceId` >=11 AND a.`ProvinceId` <=16 AND a.`CityId` NOT IN ('145','75','110','432','53') ";
                        }
                        if($region=="BALINTBNTT"){
                            $data="a.`ProvinceId` >=17 AND a.`ProvinceId` <=19 ";
                        }
                        if($region=="KALIMANTAN"){
                            $data="a.`ProvinceId` >=20 AND a.`ProvinceId` <=23 ";
                        }
                        if($region=="SULAWESI"){
                            $data="a.`ProvinceId` >=24 AND a.`ProvinceId` <=29 ";
                        }
                        if($region=="MALUKUPAPUA"){
                            $data="a.`ProvinceId` >=30 AND a.`ProvinceId` <=33 ";
                        }
						$qregion = "SELECT DISTINCT b.`BranchId` AS Branch ,b.`BranchName` AS BranchName FROM mOfficeSite a LEFT JOIN mBranch b ON a.`BranchId`=b.`BranchId`
						WHERE $data
						ORDER BY b.`BranchName` ASC";
						$exqregion = mysqli_query($db,$qregion);
						$i = 1;
						while ($rregion  = mysqli_fetch_assoc($exqregion) ) {
					?>
			<div class="card">
				<div class="card-header text-left rounded" id="heading<?php echo $i; ?>">
					<div class="img float-left mr-1" id="imgpin">
					</div>
					<button class="btn text-left btn-block rounded btn-link <?php if($i>1) echo "collapsed"; ?>" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="<?php echo ($i==1) ? 'true': 'false'; ?>" aria-controls="collapse<?php echo $i; ?>">
						<a><span class="ml-5 font-weight-bold text-decoration-none">
							<?php
							$region2 = $rregion['Branch'];
							echo $rregion['BranchName'];
							?>
						</span></a>
					</button>
				</div>
				<!-- ============== TABEL LIST CABANG ============== -->
				<div id="collapse<?php echo $i; ?>" class="collapse <?php if($i==1) echo 'show'; ?>" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordionExample">
					<div class="card-body pt-0 bordered">
						<table class="table table-sm table-hover p-3 text-left mt-5">
							<thead class="thead-dark">
								<tr>
									<th>No.</th>
									<th>Nama Gerai</th>
									<th>Alamat</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$j = 1;
								//	echo $region2;
								$qoffice = "SELECT DISTINCT
								a.OfficeSiteId,
								a.BranchId,
								b.`BranchName`,
								a.OfficeName,
								a.Address1,
								a.Address2,
								a.Address3,
								a.Geolatitude,
								a.Geolongitude
								FROM
								mOfficeSite a
								LEFT JOIN `mBranch` b ON a.`BranchId`=b.`BranchId`
								WHERE
								a.BranchId= '$region2'
								ORDER BY a.`Address3` ASC";
								$exqoffice = mysqli_query($db,$qoffice);
								while ($roffice  = mysqli_fetch_assoc($exqoffice) ) {
										?>
									<tr class="rounded bordered">
										<td><?php echo $j; ?></td>
										<td><?php echo ucwords($roffice['OfficeName']); ?></td>
										<td><?php echo ucwords(mb_strtolower($roffice['Address1'])); ?></td>
										<td><a class="text-red" href="cabang-map.php?Geolatitude=<?php echo $roffice['Geolatitude']."&Geolongitude=".$roffice['Geolongitude']."&id=".$roffice['OfficeSiteId']; ?>">detail</a></td>
									</tr>
								</tbody>
								<?php $j++; } ?>
							</table>
						</div>
					</div>
				</div>
				<?php
				$i++;
			}
		}
		?>
	</div>
</div>
</div>
</div>
</div>
</section>
<!-- ============= FOOTER =============== -->
<?php include 'footer.php'; ?>
