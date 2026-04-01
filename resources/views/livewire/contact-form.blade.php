<div class="w-full max-w-2xl mx-auto text-left">
    
    @if ($success)
        <!-- Success Message HUD -->
        <div class="bg-primary/10 border border-primary text-primary p-8 clip-cut-corner text-center animate-pulse relative overflow-hidden">
            <div class="absolute inset-0 bg-primary/5 scanline"></div>
            <h3 class="font-display font-bold text-2xl mb-2 uppercase">>> TRANSMISSION_RECEIVED</h3>
            <p class="font-mono text-sm text-slate-300">Your message has been successfully logged in the system mainframe. Stand by for response.</p>
            
            <button wire:click="resetForm" class="mt-6 text-xs font-bold tracking-widest border-b border-primary hover:text-white transition-colors uppercase cursor-pointer relative z-10">
                SEND_NEW_MESSAGE
            </button>
        </div>
    @else
        <form wire:submit.prevent="submit" class="space-y-8">
            <!-- Name Input -->
            <div class="relative group">
                <input type="text" wire:model="name" id="name" 
                    class="peer w-full bg-dark-900 border border-white/10 p-4 pl-4 text-white placeholder-transparent focus:border-primary focus:outline-none focus:ring-0 transition-colors clip-cut-corner font-mono" 
                    placeholder="Name">
                <label for="name" 
                    class="absolute left-4 -top-2.5 bg-dark-950 px-1 text-xs text-slate-500 transition-all 
                           peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-slate-500 
                           peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-primary font-display font-bold tracking-wider">
                    AGENT_NAME
                </label>
                @error('name') <span class="text-red-500 text-xs mt-1 block font-mono">/// ERROR: {{ $message }}</span> @enderror
            </div>

            <!-- Email Input -->
            <div class="relative group">
                <input type="email" wire:model="email" id="email" 
                    class="peer w-full bg-dark-900 border border-white/10 p-4 pl-4 text-white placeholder-transparent focus:border-primary focus:outline-none focus:ring-0 transition-colors clip-cut-corner font-mono" 
                    placeholder="Email">
                <label for="email" 
                    class="absolute left-4 -top-2.5 bg-dark-950 px-1 text-xs text-slate-500 transition-all 
                           peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-slate-500 
                           peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-primary font-display font-bold tracking-wider">
                    CONTACT_CHANNEL (EMAIL)
                </label>
                @error('email') <span class="text-red-500 text-xs mt-1 block font-mono">/// ERROR: {{ $message }}</span> @enderror
            </div>

            <!-- Message Input -->
            <div class="relative group">
                <textarea wire:model="message" id="message" rows="5" 
                    class="peer w-full bg-dark-900 border border-white/10 p-4 pl-4 text-white placeholder-transparent focus:border-primary focus:outline-none focus:ring-0 transition-colors clip-cut-corner font-mono resize-none" 
                    placeholder="Message"></textarea>
                <label for="message" 
                    class="absolute left-4 -top-2.5 bg-dark-950 px-1 text-xs text-slate-500 transition-all 
                           peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-slate-500 
                           peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-primary font-display font-bold tracking-wider">
                    TRANSMISSION_DATA
                </label>
                @error('message') <span class="text-red-500 text-xs mt-1 block font-mono">/// ERROR: {{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" wire:loading.attr="disabled"
                class="w-full py-4 bg-primary hover:bg-cyan-400 text-black font-display font-bold text-lg tracking-widest clip-cut-corner shadow-[0_0_15px_rgba(0,240,255,0.4)] hover:shadow-[0_0_40px_rgba(0,240,255,0.6)] transition-all hover:-translate-y-1 relative overflow-hidden group disabled:opacity-50 disabled:cursor-not-allowed">
                
                <span wire:loading.remove class="relative z-10">SEND_TRANSMISSION</span>
                
                <!-- Loading State -->
                <span wire:loading class="relative z-10 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-circle-notch fa-spin"></i> ENCRYPTING & SENDING...
                </span>
                
                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
            </button>
        </form>
    @endif
</div>