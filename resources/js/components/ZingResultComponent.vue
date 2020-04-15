<template>
    <div class="d-flex align-items-center result" v-bind:class="{hidden: isHidden}" v-if="isStreaming == true">
        <div class="border-success thumbnail" style="margin-right: 10px;margin-left: 10px;padding-right: 5px;padding-left: 5px;"><img loading="lazy" v-bind:src="thumbnail"></div>
        <div class="d-flex flex-column content">
            <strong class="title" style="margin-bottom: 5px;">{{ title }}<br></strong>
            <small class="artist">Ca sĩ thể hiện:<span style="margin-left: 10px;">{{ artist }}<br></span></small>
            <small class="duration">Thời gian:&nbsp;<span>{{ artist }}</span></small>
            <div class="form-group d-flex align-items-center download" style="margin-top: 10px;">
                <select class="form-control-sm" style="margin-right: 10px;">
                    <optgroup label="Chất lượng">
                        <option value="128" selected="">128 Kbps</option>
                        <option value="320">320 Kbps</option>
                    </optgroup>
                </select>
                <button class="btn btn-dark btn-sm" type="button">Download</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isHidden: true,
                isStreaming: true,
                title: 'Tieu de',
                artist: 'Nghe si',
                thumbnail: 'thumbnail',
                duration: '02:30'
            }
        }
    }
</script>
