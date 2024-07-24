import {registerPlugin} from '@wordpress/plugins';
import OverlaySettings from './OverlaySettings.js';
import "./editor.css";

registerPlugin("membergate-overlay-settings", {render:OverlaySettings});
