<?php

function r_daily_generate_event(){
  set_transient(
    'r_daily_events',
    r_get_random_event(),
    DAY_IN_SECONDS
  );
}