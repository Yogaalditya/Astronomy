@if ($currentScheduledConference)
<section class="latest-news section-background py-24">
	<div class="latest-news-container">
		<!-- Section Header -->
		<div class="text-center max-w-3xl mx-auto mb-16">
			<h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
				Latest News
			</h2>
		</div>

		@if ($currentScheduledConference->announcements()
		->where(function ($query) {
			$query->where('expires_at', '>', now()->startOfDay())
				  ->orWhereNull('expires_at');
		})->count() > 0)

			<!-- Announcements Grid -->
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
				@foreach ($currentScheduledConference->announcements()
				->where(function ($query) {
					$query->where('expires_at', '>', now()->startOfDay())
						->orWhereNull('expires_at');
				})
				->orderBy('created_at', 'DESC')
				->get() as $announcement)
				
					@php
						$content = $announcement->getMeta('content');
						preg_match('/<img[^>]+src="([^">]+)"/', $content, $matches);
						$imageUrl = $matches[1] ?? 'https://picsum.photos/400/200';
					@endphp

					<article class="news-card">
						<!-- Date Badge -->
						<div class="date-badge">
							<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
							</svg>
							{{ $announcement->created_at->format(Setting::get('format_date')) }}
						</div>
						
						<!-- Background Image Circle -->
						<a href="{{ route('livewirePageGroup.scheduledConference.pages.announcement-page', ['announcement' => $announcement->id]) }}" aria-label="{{ $announcement->title }}" class="block">
							<div class="card-image" style="background-image: url('{{ $imageUrl }}');"></div>
						</a>
						
						<!-- Title -->
						<h3 class="card-title">
							<a href="{{ route('livewirePageGroup.scheduledConference.pages.announcement-page', ['announcement' => $announcement->id]) }}" class="block" style="color: inherit; text-decoration: none;">
								{{ Str::limit($announcement->title, 70) }}
							</a>
						</h3>
						
						<!-- Summary -->
						<p class="card-summary">
							{{ Str::limit($announcement->getMeta('summary'), 200) }}
						</p>
						
						<!-- CTA Container -->
						<div class="card-cta">
							<a href="{{ route('livewirePageGroup.scheduledConference.pages.announcement-page', ['announcement' => $announcement->id]) }}" 
							   class="cta-link">
								Read More
								</a>
						</div>
					</article>
				@endforeach
			</div>

			<!-- View All Link -->
			<div class="mt-16 text-center">
				<a href="{{ route(App\Frontend\ScheduledConference\Pages\Announcements::getRouteName('scheduledConference')) }}"
					class="button-banner submit inline-flex items-center px-8 py-3 text-base font-medium text-white rounded-full hover:opacity-90 transition-opacity">
					View All Updates
					<svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M17 8l4 4m0 0l-4 4m4-4H3" />
					</svg>
				</a>
			</div>
		@else
			<!-- Empty State -->
			<div class="text-center py-16 px-4">
				<div class="max-w-md mx-auto">
					<svg class="mx-auto h-20 w-20 text-gray-400" fill="none" stroke="currentColor"
						viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
							d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
					</svg>
					<h3 class="mt-4 text-xl font-semibold text-gray-900">No Announcements Yet</h3>
					<p class="mt-2 text-gray-600">Stay tuned! New announcements will be posted here as they
						become available.</p>
				</div>
			</div>
		@endif
	</div>
</section>
@endif