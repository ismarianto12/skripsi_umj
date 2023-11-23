       <ul class="sortable-list" style="width: 90%;background:#fff">
           <li class="alert alert-info">
               <i class="fa fa-document"></i> Group Jenis Surat
               {{ ucfirst($jenis) }}
           </li>
           @php
               $gg = 0;
           @endphp
           @foreach ($paramscolum as $mm => $ph)
               <li class="sortable-item alert alert-info">

                   <input type="hidden" name="inputan_user_xx[]" value="tmp_surat.{{ $mm }}" />
                   <input type="hidden" name="jenis_surat_id" value="{{ $jenis }}" />
                   <i class="fa fa-list"></i>
                   @php
                       echo $ph;
                   @endphp
               </li>
               @php
                   $gg++;
               @endphp
           @endforeach

       </ul>
