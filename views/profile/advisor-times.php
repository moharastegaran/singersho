<?php
global $user;
$artist_id = $user['data']['other_info']['artist']['id'];
if ($artist_id > 0) {
    $get_times = callAPI('GET', RAW_API . 'reservation/advisor', ['rpp' => 15, 'id' => $artist_id]);
    $get_times = json_decode($get_times, true);

    $times = array();
    if (!$get_times['error']) {
        $times = $get_times['dates'];
    }


    $get_allowed_hours = callAPI('GET', RAW_API . 'reservation/allowed/hrs', false);
    $allowed_hours = json_decode($get_allowed_hours, true);
    $allowed_hours = $allowed_hours['allowed_hours'];
}
?>
<div class="dashbox">
    <div class="dashbox__title">
        <h3>زمان‌های مشاوره</h3>
    </div>
    <div class="dashbox__list-wrap">
        <div class="profile-advisor__times">
            <div class="row col-lg-6 col-md-8 col-12">
                <div class="col-md-10">
                    <div class="sign__group">
                        <input type="text" name="advisor_date" autocomplete="off"
                               placeholder="تاریخ مشاوره" class="input-large" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn-green-outline btn-add btn-large btn__add-datetime">افزودن</button>
                </div>
            </div>
            <div id="advisorDateTimesAccordion" class="accordion-icons mt-4">
                <?php if (isset($times['data'])) : ?>
                    <?php
                    $len = count($times['data']);
                    for ($index = 0; $index <= $len; $index++) :
                        $time = $index < $len ? $times['data'][$index] : null;
                        ?>
                        <?php
                        if (isset($time)) {
                            $current_hours = array_map(function ($item) {
                                return $item['allowed_hour']['id'];
                            }, $time['details']);
                        } else {
                            $current_hours = array();
                        }
                        if (count($current_hours) || !$time) :?>
                            <div class="card <?php echo !isset($time) ? 'd-none' : '' ?>"
                                 data-date="<?php echo isset($time) ? $time['shamsi_date_2'] : '0000-00-00' ?>">
                                <div class="card-header">
                                    <section class="p-0 m-0">
                                        <div role="menu" class="collapsed" data-toggle="collapse" aria-expanded="false"
                                             data-target="#advisorDateTimesAccordionNumber<?php echo $index; ?>">
                                            <div class="accordion-icon">
                                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="m9 24h-8a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2z"/>
                                                    <path d="m7 20h-6a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2z"/>
                                                    <path d="m5 16h-4a1 1 0 0 1 0-2h4a1 1 0 0 1 0 2z"/>
                                                    <path d="m13 23.955a1 1 0 0 1 -.089-2 10 10 0 1 0 -10.87-10.865 1 1 0 0 1 -1.992-.18 12 12 0 0 1 23.951 1.09 11.934 11.934 0 0 1 -10.91 11.951c-.03.003-.061.004-.09.004z"/>
                                                    <path d="m12 6a1 1 0 0 0 -1 1v5a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414l-2.707-2.707v-4.586a1 1 0 0 0 -1-1z"/>
                                                </svg>
                                            </div>
                                            <span class="faNum card-date"><?php echo isset($time) ? $time['shamsi_date_2'] : '' ?></span>
                                            <div class="icons">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke-linejoin="round"
                                                     stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="remove__items-all" data-ripple="">
                                            حذف
                                        </a>
                                    </section>
                                </div>
                                <div id="advisorDateTimesAccordionNumber<?php echo $index; ?>" class="collapse"
                                     data-parent="#advisorDateTimesAccordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="advisor__times-list mb-4">
                                                    <?php for ($i = 0; $i < count($allowed_hours); $i++): ?>
                                                        <div class="col-md-2 col-sm-4 col-12">
                                                            <li class="advisor__time-badge <?php echo in_array($allowed_hours[$i]['id'], $current_hours) ? 'selected added' : 'deleted'; ?>">
                                                                <a href="javascript:void(0)"
                                                                   data-id="<?php echo $allowed_hours[$i]['id']; ?>">
                                                                    <?php echo $allowed_hours[$i]['started_at'] . ' تا ' . $allowed_hours[$i]['ended_at']; ?>
                                                                </a>
                                                            </li>
                                                        </div>
                                                    <?php endfor; ?>
                                                </ul>
                                            </div>
                                            <div class="col-md-12">
                                                <button class="btn-purple-outline m-1 btn__select-all float-right">
                                                    انتخاب
                                                    همه
                                                </button>
                                                <button class="btn-purple m-1 btn__save-all float-left">ذخیره</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>