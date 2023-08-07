<script lang="ts">
    import CopyButton from "./CopyButton.svelte";

	export let condition;
	export let ruleset;
	export let protectMethod;
</script>

<h1>DevTools</h1>
<CopyButton content={JSON.stringify({rules:ruleset ,condition, protectMethod},null, 2)}/>
<div>
	<p>Rule:</p>
	<pre>
<code>
	{JSON.stringify(ruleset,null,2)}
</code>
</pre>
</div>

<div>
	<p>Condition:</p>
	<pre>
<code>
	{JSON.stringify(condition,null,2)}
</code>
</pre>
</div>

<div>
	<p>Protect Method:</p>
	<pre>
<code>
	{JSON.stringify(protectMethod,null,2)}
</code>
</pre>
</div>

