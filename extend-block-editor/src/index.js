import { registerPlugin } from '@wordpress/plugins';
// const {registerPlugin} = wp.plugins
import TestComp from "./testComp.jsx"

registerPlugin("testing-plugin", {render: TestComp})
