<?php

namespace App;

enum TaskStatus: string
{
    case TODO = 'TODO';
    case IN_PROGRESS = 'IN_PROGRESS';
    case DONE = 'DONE';
    case ABANDONED = 'ABANDONED';
}
