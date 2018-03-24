<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 24/03/2018
 * Time: 11:04 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Data;


class PaginationUtil
{
    public static function generatePagination($page_url, $total_rows, $rows_per_page, $current_page, $args = '', $label = 'Pages: ', $page_range = 10, $force_show = false)
    {
        $number_pages = $total_rows / $rows_per_page;
        if (floor($number_pages) < $number_pages) {
            $number_pages = floor($number_pages) + 1;
        }

        if ($number_pages <= 1 && !$force_show) {
            return '';
        }

        $args = ($args != '') ? '&' . $args : '';
        $separator = (strpos($page_url, '?')) ? '&' : '?';

        $offset = ($current_page == 1) ? 0 : (($current_page - 1) * $rows_per_page);
        $marked_page = (($total_rows - $offset) < $rows_per_page) ? ($total_rows - $offset) : $rows_per_page;

        $pagination_text = '<ul class="pagination pagination-sm pull-right" style="margin-top: 2px; margin-bottom: 8px;">';
        if ($number_pages <= 10) {
            for ($i = 1; $i <= $number_pages; $i++) {
                $wrapper_link = ($current_page == $i) ? '<li class="active"><a>{PAGE}</a></li> ' : '<li><a href="' . $page_url . $separator . 'offset=' . $i . $args . '">{PAGE}</a></li> ';
                $pagination_text .= str_replace('{PAGE}', $i, $wrapper_link);
            }
        } else {
            $middle_right = $current_page + (($page_range / 2) - 1);
            $middle_left = $current_page - (($page_range / 2) - 1);

            if ($current_page <= ($page_range / 2)) {
                $middle_right = $current_page + $page_range;
                $middle_right -= $current_page;
            }
            if ($current_page >= ($number_pages - ($page_range / 2))) {
                $middle_left = $number_pages - ($page_range - 1);
            }

            for ($i = 1; $i <= $number_pages; $i++) {
                $wrapper_link = ($current_page == $i) ? '<li class="active"><a>{PAGE}</a></li>' : '<li><a href="' . $page_url . $separator . 'offset=' . $i . $args . '">{PAGE}</a></li>';
                if ($i == 1) {
                    $ellipsis = ($current_page <= (($page_range / 2) + 1)) ? '' : '<li><a>...</a></li>';
                    $pagination_text .= str_replace('{PAGE}', $i, $wrapper_link) . $ellipsis;
                } else if ($i == $number_pages) {
                    $ellipsis = ($current_page >= ($number_pages - ($page_range / 2))) ? '' : '<li><a>...</a></li>';
                    $pagination_text .= $ellipsis . str_replace('{PAGE}', $i, $wrapper_link);
                } else if ($i <= $middle_right && $i >= $middle_left) {
                    $pagination_text .= str_replace('{PAGE}', $i, $wrapper_link);
                } else {
                    // no print...
                }
            }
            $pagination_text .= '</ul>';
        }

        if ($number_pages <= 1 && $force_show) {
            return sprintf('%s result' . ($total_rows == 1 ? '' : 's'), ($offset + $marked_page));
        } else {
            $label = sprintf('%s result' . ($total_rows == 1 ? '' : 's') . ' | Showing results %s to %s', $total_rows, ($offset + 1), ($offset + $marked_page));
            return '<nav class="pull-right" style="min-width: 100px;"><div class="pull-left" style="margin: 8px 8px 2px 2px;">'.$label . ' &mdash; </div>' . $pagination_text . ' </nav>';
        }
    }

    public static function generatePaginationBy5($page_url, $total_rows, $rows_per_page, $current_page, $args = '', $label = 'Pages: ')
    {
        $number_pages = $total_rows / $rows_per_page;
        if (floor($number_pages) < $number_pages) {
            $number_pages = floor($number_pages) + 1;
        }

        if ($number_pages <= 1) {
            return '';
        }

        $args = ($args != '') ? '&' . $args : '';
        $separator = (strpos($page_url, '?')) ? '&' : '?';

        $offset = ($current_page == 1) ? 0 : (($current_page - 1) * $rows_per_page);
        $marked_page = (($total_rows - $offset) < $rows_per_page) ? ($total_rows - $offset) : $rows_per_page;

        $pagination_text = '';
        if ($number_pages <= 10) {
            for ($i = 1; $i <= $number_pages; $i++) {
                $wrapper_link = ($current_page == $i) ? '<span class="current">{PAGE}</span> ' : '<a href="' . $page_url . $separator . 'offset=' . $i . $args . '">{PAGE}</a> ';
                $pagination_text .= str_replace('{PAGE}', $i, $wrapper_link);
            }
        } else {
            $middle_right = $current_page + 2;
            $middle_left = $current_page - 2;

            if ($current_page > ($number_pages - 5)) {
                //$middle_left = $current_page - ($number_pages - $current_page);
                $middle_left = $current_page - (4 - ($number_pages - $current_page));
                $middle_left = ($middle_left == $current_page) ? $current_page - 2 : $middle_left;
            }
            if ($current_page < 5) {
                $middle_right = $current_page + (5 - $current_page);
            }

            for ($i = 1; $i <= $number_pages; $i++) {
                $wrapper_link = ($current_page == $i) ? '<span class="current">{PAGE}</span> ' : '<a href="' . $page_url . $separator . 'offset=' . $i . $args . '">{PAGE}</a> ';
                if ($i == 1) {
                    $ellipsis = ($current_page < 5) ? '' : ' ... ';
                    $pagination_text .= str_replace('{PAGE}', $i, $wrapper_link) . $ellipsis;
                } else if ($i == $number_pages) {
                    $ellipsis = ($current_page >= ($number_pages - 3)) ? '' : ' ... ';
                    $pagination_text .= $ellipsis . str_replace('{PAGE}', $i, $wrapper_link);
                } else if ($i <= $middle_right && $i >= $middle_left) {
                    $pagination_text .= str_replace('{PAGE}', $i, $wrapper_link);
                } else {
                    // no print...
                }
            }
        }

        $label = sprintf('%s result' . ($total_rows == 1 ? '' : 's') . ' | Showing results %s to %s', $total_rows, ($offset + 1), ($offset + $marked_page));
        return $label . ' &mdash; ' . $pagination_text;
    }

    /**
     * @todo improve and clean this function
     */
    public static function generatePagination_Orig($page_url, $total_rows, $rows_per_page, $current_page, $args = '', $label = '')
    {
        $number_pages = $total_rows / $rows_per_page;
        if (floor($number_pages) < $number_pages) {
            $number_pages = floor($number_pages) + 1;
        }

        $args = ($args != '') ? '&' . $args : '';


        $offset = ($current_page == 1) ? 0 : (($current_page - 1) * $rows_per_page);
        $marked_page = (($total_rows - $offset) < $rows_per_page) ? ($total_rows - $offset) : $rows_per_page;

        $pagination_text = $total_rows . ' result' . ($total_rows == 1 ? '' : 's') . ' | Showing results ' . ($offset + 1) . ' to ' . ($offset + $marked_page) . ' |  ';
        $middle_range_starting_position = 1;
        $middle_range_ending_position = $number_pages;
        if ($current_page > 11) {
            for ($i = 1; $i <= 5; $i++) {
                if ($i > 1) {
                    $pagination_text .= ' ';
                }
                if ($i == $current_page) {
                    $pagination_text .= $i;
                } else {
                    $separator = '?';
                    if (strpos($page_url, '?')) {
                        $separator = '&';
                    }
                    $pagination_text .= '<a href="' . $page_url . $separator . 'offset=' . $i . $args . '">' . $i . '</a>';
                }
            }

            $pagination_text .= ' ... ';
            $middle_range_starting_position = $current_page - 5;
            $middle_range_ending_position = $current_page + 5;
            if ($middle_range_ending_position > $number_pages) {
                $middle_range_ending_position = $number_pages;
            }
        } else {
            if ($middle_range_starting_position + 15 < $number_pages) {
                $middle_range_ending_position = $middle_range_starting_position + 15;
            } else {
                $middle_range_ending_position = $number_pages;
            }
        }

        for ($i = $middle_range_starting_position; $i <= $middle_range_ending_position; $i++) {
            if ($i > 1) {
                $pagination_text .= ' ';
            }
            if ($i == $current_page) {
                $pagination_text .= '<span>' . $i . '</span>';
            } else {
                $separator = '?';
                if (strpos($page_url, '?')) {
                    $separator = '&';
                }
                $pagination_text .= '<a href="' . $page_url . $separator . 'offset=' . $i . $args . '">' . $i . '</a>';
            }
        }

        if ($number_pages > 21 && $current_page < ($number_pages - 5)) {
            $pagination_text .= ' ... ';

            for ($i = ($number_pages - 5); $i <= $number_pages; $i++) {
                if ($i > 1) {
                    $pagination_text .= ' ';
                }
                if ($i == $current_page) {
                    $pagination_text .= $i;
                } else {
                    $separator = '?';
                    if (strpos($page_url, '?')) {
                        $separator = '&';
                    }
                    $pagination_text .= '<a href="' . $page_url . $separator . 'offset=' . $i . $args . '">' . $i . '</a>';
                }
            }
        }

        return $pagination_text;
    }
}