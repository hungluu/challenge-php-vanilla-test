<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Faker\Factory;

function get_dummy_events () {
  $faker = Factory::create();
  $events = [];
  $min_date = '-15 days';
  $max_date = '+15 days';
  for ($i = 1; $i < 100; $i++) {
    $start_date = $faker->dateTimeBetween($min_date, $max_date);
    $end_date = clone $start_date;
    $end_date->modify('+' . $faker->numberBetween(1, 5) . ' hours');
    $name = $faker->catchPhrase;
    $events[] = [
      'id' => $i,
      'name' => $name,
      'start_date' => $start_date->format('Y-m-d H:i:00'),
      'end_date' => $end_date->format('Y-m-d H:i:00'),
      'status' => $faker->randomElement(['cancelled', 'scheduled', 'scheduled'])
    ];
  }

  return $events;
}

function get_dummy_sql () {
  $events = get_dummy_events();
  $sql_list = [];
  foreach ($events as $event) {
    $sql_list[] = sprintf(
      "INSERT INTO schedule (name, status, start_date, end_date) VALUES ('%s', '%s', '%s', '%s');",
      $event['name'],
      $event['status'],
      $event['start_date'],
      $event['end_date']
    );
  }
  
  if (count($sql_list)) {
    $sql = implode(PHP_EOL, $sql_list);
    return $sql;
  }
  
  return '';
}

function generate_dummy_data () {
  $dummy_event_sql = get_dummy_sql();
  if ($dummy_event_sql) {
    return file_put_contents(__DIR__ . '/../migrations/' . date('Ymd_His') . '_generate_dummy_data.sql', $dummy_event_sql); 
  } else {
    return false;
  }
}

// Please run this command on
// cd /migrations && for f in *.sql; do if [[ ! -f "/tmp/$f.migrated" ]]; then psql -U postgres -d test -f "$f" && touch "/tmp/$f.migrated"; fi; done
generate_dummy_data();
