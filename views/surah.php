<?php require_once('common/header.php'); ?>
<?php require_once('common/navigation.php'); ?>

<?php use AlQuranCloud\Renderer\Ayah; ?>
<?php use AlQuranCloud\Renderer\Generic; ?>
<?php use AlQuranCloud\Renderer\Surah; ?>

<div class="playerBar" style="bottom: 0; margin-bottom: 60px; position: fixed; width: 100%; z-index: 1000;">
<div class="container">
<div class="row" id="surahConfigurator">
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <form>
      <div class="form-group" class="">
        <select id="surahSelector" name="surahSelector" title="Select Surah" class="form-control" >
          <?php foreach ($suwar->data as $ss) { ?>
          <option value="<?= $ss->number; ?>" <?= $surah->data->number == $ss->number ? 'selected="selected"' : ''; ?>><?= $ss->name; ?> (<?= $ss->englishName; ?>)</option>
          <?php } ?>
        </select>
      </div>
    </form>
  </div>
  <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
    <form class="form-inline align-center">
      <div class="form-group">
        <label for="editionSelector">Show translation </label>
        <select id="editionSelector" name="editionSelector" multiple="multiple" title="Select Language" class="form-control" >
          <?php foreach (Generic::getEditionsByLanguage($editions['editions']->data) as  $language => $edition) { ?>
          <optgroup label="<?= $language; ?>">
            <?php foreach ($edition as $e) { ?>
              <option value="<?= $e->identifier; ?>" <?= isset($surahEdition) && $surahEdition->data->edition->identifier == $e->identifier ? 'selected="selected"' : ''; ?>><?= $e->name; ?></option>
            <?php } ?>
          </optgroup>
          <?php } ?>
        </select>
      </div>
    </form>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
  <audio id="surahPlayer" controls="controls" class="">
    <?php if ($surah->data->number > 1 && $surah->data->number != 9) { ?>
    <source src="https://cdn.alquran.cloud/media/audio/ayah/ar.alafasy/1/high" title="Bismillah" type="audio/mp3"/>
    <?php } ?>
    <?php foreach ($surah->data->ayahs as $ayah) { ?>
      <source src="https://cdn.alquran.cloud/media/audio/ayah/ar.alafasy/<?= $ayah->number; ?>/high" title="<?= $surah->data->number; ?>_<?= $ayah->numberInSurah; ?>" type="audio/mp3"/>
    <?php } ?>
  </audio>
  </div>
</div>
</div>
</div>

<!--<div class="container" style="padding-top: 70px; background:url(/public/images/parchment3.jpg); background-style: cover;">-->
<div class="container" style="">

	<?php
	$ayahs = (array) $surah->data->ayahs;
	if (isset($surahEdition)) {
		$ayahEditions = (array) $surahEdition->data->ayahs;
	} ?>

  <?= Surah::renderSurahHeaderRow($surah); ?>
  <?php if ($surah->data->number != 9) { ?>
  <div class="lead font-mequran2 align-center style-ayah">
    بِسْمِ ٱللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
  </div>
  <?php } ?>
  <hr />

	<div class="row">
		<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="">
			<?php
	  		if (!isset($surahEdition)) {
				echo Surah::renderAyahs($surah, $ayahs);
			} else {
				echo Surah::renderAyahs($surah, $ayahs, $surahEdition, $ayahEditions);
			}
			?>
		</div>
	</div>
	<hr />
</div>

<script src="/public/libraries/mediaelementjs-2.21.2/build/mediaelement-and-player.js"></script>
<script src="/public/libraries/mep-feature-playlist/mep-feature-playlist.js"></script>
<script src="/public/js/jquery.mediaplayer.js"></script>
<script src="/public/js/jquery.surah.js"></script>

<script>
$(function() {
	var player = $.alQuranMediaPlayer.getSurahPlayer('#surahPlayer');
	$('#editionSelector').multiselect({ enableFiltering: true, enableCaseInsensitiveFiltering: true, maxHeight: 400, dropUp: true});
	$.alQuranSurah.editions('#editionSelector', '<?= $surah->data->number; ?>');
	$.alQuranSurah.surahs('#surahSelector');
	$.alQuranSurah.playThisAyah(player);
	$.alQuranSurah.zoomIntoThisAyah();
});
</script>


<?php // ================================================================ // ?>
<?php require_once('common/footer.php'); ?>
