/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import { useBlockProps } from "@wordpress/block-editor";

/**
 * Built-in components from WordPress.
 */
import {
	Flex,
	FlexBlock,
	FlexItem,
	ExternalLink,
	SelectControl,
	TextareaControl,
} from "@wordpress/components";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();
	return (
		<div {...blockProps}>
			<Flex>
				<FlexBlock>
					<SelectControl
						label={__("Alignment")}
						value={attributes.alignment}
						onChange={(val) => setAttributes({ alignment: val })}
						options={[
							{ value: "left", label: __("Left") },
							{ value: "center", label: __("Center") },
							{ value: "right", label: __("Right") },
						]}
					/>
				</FlexBlock>
				<FlexBlock>
					<SelectControl
						label={__("View mode")}
						value={attributes.viewMode}
						onChange={(val) => setAttributes({ viewMode: val })}
						options={[
							{ value: "clip", label: __("Clip") },
							{ value: "full", label: __("Full") },
							{ value: "mini", label: __("Mini") },
						]}
					/>
				</FlexBlock>
				<FlexBlock></FlexBlock>
			</Flex>
			<TextareaControl
				label={
					<Flex>
						<FlexItem>{__("Lyrics")}</FlexItem>
						<FlexItem>
							<ExternalLink
								href="https://wordpress.org/plugins/rabbit-lyrics/"
								target="_blank"
							>
								({__("user documents")})
							</ExternalLink>
						</FlexItem>
					</Flex>
				}
				value={attributes.lyrics}
				onChange={(val) => setAttributes({ lyrics: val })}
				rows={Math.max((attributes.lyrics || "").split("\n").length, 4)}
			/>
		</div>
	);
}
