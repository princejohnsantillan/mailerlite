import { ref } from "vue"

const fields = ref([])

export function useFieldsStore() {
    const loadFields = async () => {
        const response = await fetch("/api/field")
        const body = await response.json()

        fields.value = body.data
    }

    const deleteField = async (id) => {
        await fetch(`/api/field/${id}`, { method: "DELETE" })

        loadFields()
    }

    return {
        loadFields,
        deleteField,
        fields
    }
}
