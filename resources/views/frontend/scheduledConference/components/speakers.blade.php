@if ($currentScheduledConference?->speakers->isNotEmpty())
<section id="speakers">
	<div class="container mx-auto w-full px-4 max-w-7xl">
		<div class="space-y-24">
			@foreach ($currentScheduledConference->speakerRoles as $role)
				@if ($role->speakers->isNotEmpty())
					<div class="flex flex-col items-center">
						<h3 class="text-4xl font-bold text-gray-800 mb-16 text-center">{{ $role->name }}
						</h3>
						<div class="flex flex-wrap justify-center gap-12">
							@foreach ($role->speakers as $speaker)
								<div class="flex flex-col items-center text-center max-w-xs">
									<!-- Foto bulat tanpa card -->
									<div class="mb-0">
										@if($speaker->getFilamentAvatarUrl())
											<img
												class="h-56 w-56 object-cover rounded-full border-4 border-gray-200 shadow-lg"
												src="{{ $speaker->getFilamentAvatarUrl() }}"
												alt="{{ $speaker->fullName }}"
												onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
											/>
											<div class="h-56 w-56 rounded-full border-4 border-gray-200 shadow-lg bg-gradient-to-br from-blue-500 to-purple-600 items-center justify-center hidden">
												<span class="text-white text-4xl font-bold">
													{{ strtoupper(substr($speaker->fullName, 0, 2)) }}
												</span>
											</div>
										@else
											<div class="h-56 w-56 rounded-full border-4 border-gray-200 shadow-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
												<span class="text-white text-4xl font-bold">
													{{ strtoupper(substr($speaker->fullName, 0, 2)) }}
												</span>
											</div>
										@endif
									</div>
									
									<!-- Card untuk nama dan info -->
									<div class="bg-white rounded-lg shadow-lg border border-gray-200 w-full -mt-10 relative z-10"> 
										<h4 class="text-2xl font-bold text-gray-900 mb-3">
											{{ $speaker->fullName }}
										</h4>

										@if ($speaker->getMeta('affiliation'))
											<p class="text-lg text-yellow-400 mb-4">
												{{ $speaker->getMeta('affiliation') }}
											</p>
										@endif
										
										@if($speaker->getMeta('scopus_url') || $speaker->getMeta('google_scholar_url') || $speaker->getMeta('orcid_url'))
											<div class="cf-committee-scholar flex justify-center items-center gap-3 mb-4">
												@if($speaker->getMeta('orcid_url'))
													<a href="{{ $speaker->getMeta('orcid_url') }}" target="_blank" class="hover:scale-110 transition-transform">
														<x-academicon-orcid class="w-6 h-6 text-[#A6CE39]" />
													</a>
												@endif
												@if($speaker->getMeta('google_scholar_url'))
													<a href="{{ $speaker->getMeta('google_scholar_url') }}" target="_blank" class="hover:scale-110 transition-transform">
														<x-academicon-google-scholar class="w-6 h-6 text-[#4285F4]" />
													</a>
												@endif
												@if($speaker->getMeta('scopus_url'))
													<a href="{{ $speaker->getMeta('scopus_url') }}" target="_blank" class="hover:scale-110 transition-transform">
														<x-academicon-scopus class="w-6 h-6 text-[#e9711c]" />
													</a>
												@endif
											</div>
										@endif
										
										@if ($speaker->getMeta('bio'))
											<p class="text-gray-600 text-base line-clamp-3">
												{{ $speaker->getMeta('bio') }}
											</p>
										@endif
									</div>
								</div>
							@endforeach
						</div>
					</div>
				@endif
			@endforeach
		</div>
	</div>
</section>
@endif