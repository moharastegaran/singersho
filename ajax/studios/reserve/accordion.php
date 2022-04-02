<?php

global $allowed_hours;
global $times;
global $is_new;

if (isset($times)) : ?>
    <?php
    $len = $is_new ? 1 : count($times);
    for ($index = 0; $index < $len; $index++) :
        $time = !$is_new ? $times[$index] : null;
        ?>
        <?php
        if (isset($time)) {
            $current_hours = array_map(function ($item) {
                return $item['allowed_hour']['id'];
            }, $time['details']);
        } else {
            $current_hours = array();
        }
//        if (count($current_hours) || !$time) :?>
            <div class="card <?php #echo !isset($time) ? 'd-none' : '' ?>"
                 data-date="<?php echo isset($time) ? $time['shamsi_date_2'] : '0000-00-00'
                 ?>">
                <div class="card-header">
                    <section class="p-0 m-0">
                        <div role="menu" class="collapsed" data-toggle="collapse"
                             aria-expanded="false"
                             data-target="#studioReserveDateTimesAccordionNumber<?php echo $index; ?>">
                            <div class="accordion-icon">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m9 24h-8a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2z"/>
                                    <path d="m7 20h-6a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2z"/>
                                    <path d="m5 16h-4a1 1 0 0 1 0-2h4a1 1 0 0 1 0 2z"/>
                                    <path d="m13 23.955a1 1 0 0 1 -.089-2 10 10 0 1 0 -10.87-10.865 1 1 0 0 1 -1.992-.18 12 12 0 0 1 23.951 1.09 11.934 11.934 0 0 1 -10.91 11.951c-.03.003-.061.004-.09.004z"/>
                                    <path d="m12 6a1 1 0 0 0 -1 1v5a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414l-2.707-2.707v-4.586a1 1 0 0 0 -1-1z"/>
                                </svg>
                            </div>
                            <span class="faNum card-date">
                                                            <?php echo isset($time) ? $time['shamsi_date_2'] : '' ?></span>
                            <div class="icons">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke-linejoin="round"
                                     stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="remove__items-all" data-ripple="">
                            حذف
                        </a>
                    </section>
                </div>
                <div id="studioReserveDateTimesAccordionNumber<?php echo $index; ?>" class="collapse"
                     data-parent="#studioReserveDateTimesAccordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="reserve__times-list mb-4">
                                    <?php for ($i = 0; $i < count($allowed_hours); $i++): ?>
                                        <div class="col-md-2 col-sm-4 col-12 px-md-1">
                                            <li class="reserve__time-badge <?php echo in_array($allowed_hours[$i]['id'], $current_hours) ? 'selected added' : 'deleted'; ?>">
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
                                <!--                                    <button class="btn-purple-outline m-1 btn__select-all float-right">-->
                                <!--                                        انتخاب-->
                                <!--                                        همه-->
                                <!--                                    </button>-->
                                <button class="btn-purple m-1 btn__save-all float-left">ذخیره
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!--        --><?php //endif; ?>
    <?php endfor; ?>
<?php endif; ?>