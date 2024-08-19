<?php

namespace NSCL\WordPress\Async;

class BatchesList implements \Iterator
{
    protected $process = 'wpbg_process'; // Name of the backgorund process

    /**
     * @var array [Batch name => TasksList object or NULL]. If NULL then load
     * the batch only when required (lazy loading).
     */
    protected $batches = [];
    protected $batchNames = [];
    protected $currentIndex = 0;
    protected $lastIndex = -1;

    /**
     * @param array $tasksBatches [Batch name => TasksList object or NULL]
     * @param string $processName
     */
    public function __construct($tasksBatches, $processName)
    {
        $this->process    = $processName;
        $this->batches    = $tasksBatches;
        $this->batchNames = array_keys($tasksBatches);
        $this->lastIndex  = count($this->batchNames) - 1;
    }

    public function removeBatch($batchName)
    {
        if (array_key_exists($batchName, $this->batches)) {
            $this->batches[$batchName]->delete();
            unset($this->batches[$batchName]);

            // It's not necessary to remove $batchName from $this->batchNames
            // here. After rewind() all will be OK
        }
    }

    public function save()
    {
        array_walk($this->batches, function ($batch) {
            if (!is_null($batch)) {
                $batch->save();
            }
        });
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->batches);
    }

    /**
     * @return bool
     */
    public function isFinished()
    {
        return $this->count() == 0;
    }

    public function rewind()
    {
        // Reset the list of names (get rid of removed ones)
        $this->batchNames = array_keys($this->batches);
        $this->currentIndex = 0;
        $this->lastIndex = count($this->batchNames) - 1;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->currentIndex <= $this->lastIndex;
    }

    /**
     * @return \NSCL\WordPress\Async\TasksList
     */
    public function current()
    {
        $currentBatchName = $this->key();
        $currentBatch = $this->batches[$currentBatchName];

        // Load the batch
        if (is_null($currentBatch)) {
            $batchTasks = get_option($currentBatchName, []);
            $currentBatch = new TasksList($batchTasks, $this->process, $currentBatchName);

            $this->batches[$currentBatchName] = $currentBatch;
        }

        return $currentBatch;
    }

    /**
     * @return string
     */
    public function key()
    {
        return $this->batchNames[$this->currentIndex];
    }

    public function next()
    {
        // We will not have "gaps" in indexes because we always remove only the
        // current batch
        $this->currentIndex++;
    }

    /**
     * Get value of read-only field.
     *
     * @param string $name Field name.
     * @return mixed Field value or NULL.
     */
    public function __get($name)
    {
        if (in_array($name, ['process'])) {
            return $this->$name;
        } else {
            return null;
        }
    }

    /**
     * @param array $tasks
     * @param int $batchSize
     * @param string $processName
     * @return static
     */
    public static function createWithTasks($tasks, $batchSize, $processName)
    {
        $tasksBatches = array_chunk($tasks, $batchSize);
        $batches = [];

        foreach ($tasksBatches as $tasksBatch) {
            $batch = new TasksList($tasksBatch, $processName);
            $batches[$batch->name] = $batch;
        }

        return new static($batches, $processName);
    }

    /**
     * @param string $processName
     * @return static
     *
     * @global \wpdb $wpdb
     */
    public static function createFromOptions($processName)
    {
        global $wpdb;

        $batchNames = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT `option_name` FROM {$wpdb->options} WHERE `option_name` LIKE %s ORDER BY `option_id` ASC",
                esc_sql_underscores($processName . '_batch_%')
            )
        );

        // [Batch name => NULL]
        $batches = array_combine($batchNames, array_fill(0, count($batchNames), null));

        return new static($batches, $processName);
    }

    /**
     * @param string $processName
     *
     * @global \wpdb $wpdb
     */
    public static function removeAll($processName)
    {
        global $wpdb;

        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->options} WHERE `option_name` LIKE %s",
                esc_sql_underscores($processName . '_batch_%')
            )
        );
    }
}
