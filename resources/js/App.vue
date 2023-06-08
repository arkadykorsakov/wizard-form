<template>
    <div class="container" id="app">
        <AppAlert :message="message" v-if="message" @close="closeAlert" />
        <div class="card">
            <h1>Анкетирование пользователей</h1>
            <div class="steps">
                <div class="steps-content">
                    <KeepAlive>
                        <template v-if="activeIndex === 0">
                            <AppInput
                                name="surname"
                                label="Фамилия"
                                v-model.trim="v$.surname.$model"
                                :errors="v$.surname.$errors"
                            />
                            <AppInput
                                name="name"
                                label="Имя"
                                v-model.trim="v$.name.$model"
                                :errors="v$.name.$errors"
                            />
                            <AppInput
                                name="patronymic"
                                label="Отчество"
                                v-model.trim="v$.patronymic.$model"
                                :errors="v$.patronymic.$errors"
                            />
                            <AppInput
                                type="date"
                                name="date_birth"
                                label="Дата рождения"
                                v-model.trim="v$.date_birth.$model"
                                :errors="v$.date_birth.$errors"
                            />
                            <AppGroupChoice
                                label="Выберите пол"
                                :errors="v$.gender.$errors"
                            >
                                <AppRadioButton
                                    name="gender"
                                    v-model="v$.gender.$model"
                                    :option="{
                                        label: 'Мужчина',
                                        value: 'Мужчина',
                                    }"
                                />
                                <AppRadioButton
                                    name="gender"
                                    v-model="v$.gender.$model"
                                    :option="{
                                        label: 'Женщина',
                                        value: 'Женщина',
                                    }"
                                />
                            </AppGroupChoice>
                        </template>
                    </KeepAlive>
                    <KeepAlive>
                        <template v-if="activeIndex === 1">
                            <AppInput
                                type="tel"
                                name="tel"
                                label="Телефон"
                                v-model="v$.tel.$model"
                                :errors="v$.tel.$errors"
                            />
                            <AppInput
                                name="city"
                                label="Город"
                                v-model="v$.city.$model"
                                :errors="v$.city.$errors"
                            />
                            <AppInput
                                name="email"
                                label="Email"
                                v-model="v$.email.$model"
                                :errors="v$.email.$errors"
                            />
                        </template>
                    </KeepAlive>
                    <KeepAlive>
                        <template v-if="activeIndex === 2">
                            <AppSelect
                                label="Оценка приложения"
                                name="star"
                                v-model="v$.star.$model"
                                :errors="v$.star.$errors"
                                defaultOption="Оцените приложение"
                                :options="[
                                    { label: '1', value: '1' },
                                    { label: '2', value: '2' },
                                    { label: '3', value: '3' },
                                    { label: '4', value: '4' },
                                    { label: '5', value: '5' },
                                    { label: '6', value: '6' },
                                    { label: '7', value: '7' },
                                    { label: '8', value: '9' },
                                    { label: '10', value: '10' },
                                ]"
                            />
                            <AppGroupChoice
                                label="Выберите опции"
                                :errors="v$.options.$errors"
                            >
                                <AppCheckBox
                                    name="options"
                                    v-model="v$.options.$model"
                                    :option="{
                                        label: 'Промокоды',
                                        value: 'Промокоды',
                                    }"
                                />
                                <AppCheckBox
                                    name="options"
                                    label=""
                                    v-model="v$.options.$model"
                                    :option="{
                                        label: 'Экспресс доставка',
                                        value: 'Экспресс доставка',
                                    }"
                                />
                                <AppCheckBox
                                    name="options"
                                    label=""
                                    v-model="v$.options.$model"
                                    :option="{
                                        label: 'Оплата в рассрочку',
                                        value: 'Оплата в рассрочку',
                                    }"
                                />
                            </AppGroupChoice>
                            <AppTextarea
                                name="comment"
                                label="Комментарий"
                                v-model="v$.comment.$model"
                                :errors="v$.comment.$errors"
                            />
                        </template>
                    </KeepAlive>
                    <template v-if="activeIndex === steps.length - 1">
                        <div><b>Фамилия: </b> {{ v$.surname.$model }}</div>
                        <div><b>Имя: </b> {{ v$.name.$model }}</div>
                        <div><b>Отчество: </b> {{ v$.patronymic.$model }}</div>
                        <div><b>Пол: </b> {{ v$.gender.$model }}</div>
                        <div>
                            <b>Дата рождения: </b> {{ v$.date_birth.$model }}
                        </div>
                        <div><b>Телефон: </b> {{ v$.tel.$model }}</div>
                        <div><b>Email: </b> {{ v$.email.$model }}</div>
                        <div><b>Город: </b> {{ v$.city.$model }}</div>
                        <div><b>Оценка: </b> {{ v$.star.$model }}</div>
                        <div>
                            <b>Опции: </b>
                            <span
                                v-for="option in v$.options.$model"
                                :key="option"
                                >{{ option }};
                            </span>
                        </div>
                        <div>
                            <b>Комментарий: </b>
                            {{ v$.comment.$model }}
                        </div>
                    </template>
                </div>
                <ul class="steps-list" v-if="isActive">
                    <li
                        class="steps-item"
                        v-for="(step, idx) in steps"
                        :class="{
                            active: idx === activeIndex,
                            done: idx < activeIndex,
                        }"
                        :key="idx"
                    >
                        <button
                            :disabled="nextDisabled(idx)"
                            @click="setActive(idx)"
                        >
                            {{ step }}
                        </button>
                    </li>
                </ul>
                <div v-if="isActive">
                    <button class="btn" :disabled="prevDisabled" @click="prev">
                        Назад
                    </button>
                    <button class="btn primary" @click="nextOfFinish">
                        {{ isLastStep ? "Оправить" : "Вперед" }}
                    </button>
                </div>
                <div v-else>
                    <button class="btn" @click="reset">Начать заново</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { computed, reactive, ref } from "vue";
import useVuelidate from "@vuelidate/core";
import { email, helpers, required, sameAs } from "@vuelidate/validators";
import AppInput from "./components/ui/AppInput.vue";
import AppTextarea from "./components/ui/AppTextarea.vue";
import AppSelect from "./components/ui/AppSelect.vue";
import AppRadioButton from "./components/ui/AppRadioButton.vue";
import AppGroupChoice from "./components/ui/AppGroupChoice.vue";
import AppCheckBox from "./components/ui/AppCheckBox.vue";
import axios from "axios";
import AppAlert from "./components/ui/AppAlert.vue";

export default {
    components: {
        AppInput,
        AppTextarea,
        AppSelect,
        AppRadioButton,
        AppGroupChoice,
        AppCheckBox,
        AppAlert,
    },
    setup() {
        const activeIndex = ref(0);
        const isActive = ref(true);
        const steps = ref([1, 2, 3, 4]);
        const message = ref();

        const state = reactive({
            surname: "",
            name: "",
            patronymic: "",
            date_birth: "",
            gender: "",
            tel: "+7",
            city: "",
            email: "",
            star: "",
            options: reactive([]),
            comment: "",
        });

        const prev = () => {
            if (activeIndex.value !== 0) {
                activeIndex.value--;
            }
        };

        const nextDisabled = (idx) => {
            return idx > activeIndex.value + 1;
        };

        const prevDisabled = computed(() => {
            return activeIndex.value === 0;
        });

        const isLastStep = computed(() => {
            return activeIndex.value === steps.value.length - 1;
        });

        const rules = computed(() => ({
            surname: {
                required: helpers.withMessage(
                    "Обязательное для заполнения поле",
                    required
                ),
            },
            name: {
                required: helpers.withMessage(
                    "Обязательное для заполнения поле",
                    required
                ),
            },
            patronymic: {
                required: helpers.withMessage(
                    "Обязательное для заполнения поле",
                    required
                ),
            },
            date_birth: {
                required: helpers.withMessage(
                    "Обязательное для заполнения поле",
                    required
                ),
            },
            gender: {
                required: helpers.withMessage(
                    "Обязательное для заполнения поле",
                    required
                ),
            },
            city: {},
            tel:
                activeIndex.value > 0
                    ? {
                          required: helpers.withMessage(
                              "Обязательное для заполнения поле",
                              required
                          ),
                          tel: helpers.withMessage(
                              "Неверный формат (+7XXXXXXXXXX)",
                              helpers.regex(/\+7[0-9]{7,14}/g)
                          ),
                      }
                    : {},
            email:
                activeIndex.value > 0
                    ? {
                          required: helpers.withMessage(
                              "Обязательное для заполнения поле",
                              required
                          ),
                          email: helpers.withMessage("Невалидный Email", email),
                      }
                    : {},
            star:
                activeIndex.value > 1
                    ? {
                          required: helpers.withMessage(
                              "Обязательное для заполнения поле",
                              required
                          ),
                      }
                    : {},
            comment: {},
            options: {},
        }));

        const v$ = useVuelidate(rules, state);

        const submitForm = async () => {
            v$.value.$touch();
            if (v$.value.$error) return;

            try {
                await axios.post("/api/questionnaire", state);
                message.value = {
                    type: "primary",
                    value: "Анкетирование отправлено",
                };
            } catch (e) {
                message.value = {
                    type: "danger",
                    value: "Непредвиденная ошибка",
                };
            }

            setTimeout(() => {
                message.value = "";
            }, 5000);
        };

        const reset = () => {
            activeIndex.value = 0;
            isActive.value = true;
            state.surname = "";
            state.name = "";
            state.patronymic = "";
            state.date_birth = "";
            state.gender = "";
            state.tel = "+7";
            state.city = "";
            state.email = "";
            state.star = "";
            state.options = [];
            state.comment = "";
            v$.value.$reset();
        };

        const setActive = (idx) => {
            if (idx > activeIndex.value) {
                v$.value.$touch();
                if (v$.value.$error) return;
            }
            activeIndex.value = idx;
        };

        const nextOfFinish = () => {
            if (activeIndex.value !== steps.value.length - 1) {
                v$.value.$touch();
                if (v$.value.$error) return;
                activeIndex.value++;
            } else {
                submitForm();
                isActive.value = false;
            }
        };

        const closeAlert = () => {
            message.value = "";
        };

        return {
            prev,
            reset,
            nextOfFinish,
            setActive,
            prevDisabled,
            isLastStep,
            activeIndex,
            isActive,
            steps,
            nextDisabled,
            v$,
            state,
            message,
            closeAlert,
        };
    },
};
</script>

<style></style>
