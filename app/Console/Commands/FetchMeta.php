<?php

declare(strict_types=1);

/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D Community Edition is open-sourced software licensed under the GNU Affero General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D Community Edition
 *
 * @author     HDVinnie <hdinnovations@protonmail.com>
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 */

namespace App\Console\Commands;

use App\Models\Torrent;
use App\Services\Tmdb\TMDBScraper;
use Exception;
use Illuminate\Console\Command;
use Throwable;

class FetchMeta extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'fetch:meta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches Meta Data For New System On Preexisting Torrents';

    /**
     * Execute the console command.
     *
     * @throws Exception|Throwable If there is an error during the execution of the command.
     */
    final public function handle(): void
    {
        $this->alert('Meta Fetcher Started');

        $tmdbScraper = new TMDBScraper();
        $torrents = Torrent::with('category')->select('tmdb', 'category_id', 'name')->whereNotNull('tmdb')->where('tmdb', '!=', 0)->oldest()->get();

        foreach ($torrents as $torrent) {
            sleep(3);

            if ($torrent->category->tv_meta) {
                $tmdbScraper->tv($torrent->tmdb);
                $this->info(\sprintf('(%s) Metadata Fetched For Torrent %s ', $torrent->category->name, $torrent->name));
            }

            if ($torrent->category->movie_meta) {
                $tmdbScraper->movie($torrent->tmdb);
                $this->info(\sprintf('(%s) Metadata Fetched For Torrent %s ', $torrent->category->name, $torrent->name));
            }
        }

        $this->alert('Meta Fetcher Complete');
    }
}
