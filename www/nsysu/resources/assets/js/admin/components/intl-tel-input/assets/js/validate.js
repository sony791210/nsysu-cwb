import { parse as parseCustom, format as formatCustom, isValidNumber as isValidNumberCustom, getNumberType as getNumberTypeCustom } from 'libphonenumber-js/custom'
import metadata from '../metadata.mobile.json'

export const parse = (...args) => parseCustom(...args, metadata)

export const format = (...args) => formatCustom(...args, metadata)

export const isValidNumber = (...args) => isValidNumberCustom(...args, metadata)

export const getNumberType = (...args) => getNumberTypeCustom(...args, metadata)